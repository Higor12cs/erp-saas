<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Select2 from "@/Components/Select2.vue";
import InputField from "@/Components/InputField.vue";
import axios from "axios";

const props = defineProps({
    order: Object,
});

const emit = defineEmits(["submit"]);

const form = useForm({
    issue_date:
        props.order?.issue_date?.slice(0, 10) ||
        new Date().toISOString().slice(0, 10),
    customer_id: props.order?.customer_id || "",
    discount: Number(props.order?.discount || 0),
    fees: Number(props.order?.fees || 0),
    observation: props.order?.observation || "",
    items: props.order?.items?.map((item) => ({
        id: item.id,
        product_id: item.product_id,
        quantity: Number(item.quantity),
        unit_price: Number(item.unit_price),
        discount: Number(item.discount || 0),
        fees: Number(item.fees || 0),
    })) || [defaultItem()],
});

function defaultItem() {
    return {
        product_id: "",
        quantity: 1,
        unit_price: 0,
        discount: 0,
        fees: 0,
    };
}

const customers = ref([]);
const products = ref([]);
const loading = ref(false);
const selectedProductInfo = ref({});

const subtotal = computed(() => {
    return form.items.reduce((sum, item) => {
        return sum + Number(item.quantity) * Number(item.unit_price);
    }, 0);
});

const total = computed(() => {
    return subtotal.value - Number(form.discount) + Number(form.fees);
});

const getItemTotal = (item) => {
    const quantity = Number(item.quantity);
    const unitPrice = Number(item.unit_price);
    const discount = Number(item.discount || 0);
    const fees = Number(item.fees || 0);

    return (quantity * unitPrice - discount + fees).toFixed(2);
};

const addItem = () => {
    form.items.push(defaultItem());
};

const removeItem = (index) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

const fetchProductDetails = async (productId, index) => {
    if (!productId) return;

    loading.value = true;
    try {
        const response = await axios.get(route("api.products.search"), {
            params: { ids: productId },
        });

        if (response.data.data.length > 0) {
            const product = response.data.data[0];
            selectedProductInfo.value[productId] = product;

            form.items[index].unit_price = Number(product.price);
        }
    } catch (error) {
        console.error("Error fetching product details:", error);
    } finally {
        loading.value = false;
    }
};

const fetchInitialData = async () => {
    if (props.order) {
        if (props.order.customer_id) {
            try {
                const response = await axios.get(
                    route("api.customers.search"),
                    {
                        params: { ids: props.order.customer_id },
                    }
                );
                customers.value = response.data.data;
            } catch (error) {
                console.error("Error fetching customer:", error);
            }
        }

        const productIds = props.order.items
            .map((item) => item.product_id)
            .filter((id) => id)
            .join(",");

        if (productIds) {
            try {
                const response = await axios.get(route("api.products.search"), {
                    params: { ids: productIds },
                });

                products.value = response.data.data;

                response.data.data.forEach((product) => {
                    selectedProductInfo.value[product.id] = product;
                });
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        }
    }
};

const submit = () => {
    emit("submit", form);
};

watch(
    () => form.items,
    () => {
        form.items.forEach((item, index) => {
            form.items[index].quantity = Number(item.quantity);
            form.items[index].unit_price = Number(item.unit_price);
            form.items[index].discount = Number(item.discount || 0);
            form.items[index].fees = Number(item.fees || 0);
        });
    },
    { deep: true }
);

onMounted(() => {
    fetchInitialData();
});
</script>

<template>
    <form @submit.prevent="submit">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="issue_date">Data de Emissão</label>
                    <input
                        id="issue_date"
                        v-model="form.issue_date"
                        type="date"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.issue_date }"
                        required
                    />
                    <div class="invalid-feedback">
                        {{ form.errors.issue_date }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="customer">Cliente</label>
                    <Select2
                        id="customer"
                        v-model="form.customer_id"
                        :options="customers"
                        :class="{ 'is-invalid': form.errors.customer_id }"
                        placeholder="Pesquisar"
                        :searchUrl="route('api.customers.search')"
                        required
                    />
                    <div class="invalid-feedback">
                        {{ form.errors.customer_id }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <div v-if="form.errors.items" class="alert alert-danger">
                {{ form.errors.items }}
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 40%">Produto</th>
                            <th>Quantidade</th>
                            <th>Preço Unit.</th>
                            <th>Preço Total</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in form.items" :key="index">
                            <td>
                                <Select2
                                    v-model="item.product_id"
                                    :options="products"
                                    :class="{
                                        'is-invalid':
                                            form.errors[
                                                `items.${index}.product_id`
                                            ],
                                    }"
                                    placeholder="Pesquisar"
                                    :searchUrl="route('api.products.search')"
                                    @change="
                                        fetchProductDetails(
                                            item.product_id,
                                            index
                                        )
                                    "
                                    required
                                />
                                <div class="invalid-feedback">
                                    {{
                                        form.errors[`items.${index}.product_id`]
                                    }}
                                </div>
                            </td>
                            <td>
                                <InputField
                                    :id="`quantity-${index}`"
                                    v-model.number="item.quantity"
                                    type="number"
                                    min="0.01"
                                    step="0.01"
                                    :error="
                                        form.errors[`items.${index}.quantity`]
                                    "
                                    required
                                />
                            </td>
                            <td>
                                <InputField
                                    :id="`unit-price-${index}`"
                                    v-model.number="item.unit_price"
                                    maskType="currency"
                                    :error="
                                        form.errors[`items.${index}.unit_price`]
                                    "
                                    required
                                />
                            </td>
                            <td>
                                {{ getItemTotal(item) }}
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    @click="removeItem(index)"
                                    :disabled="form.items.length <= 1"
                                >
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-default"
                                    @click="addItem"
                                >
                                    <i class="fas fa-plus"></i>
                                    &nbsp; Adicionar Item
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="discount">Desconto Total</label>
                    <InputField
                        id="discount"
                        v-model.number="form.discount"
                        maskType="currency"
                        :error="form.errors.discount"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fees">Taxas Adicionais</label>
                    <InputField
                        id="fees"
                        v-model.number="form.fees"
                        maskType="currency"
                        :error="form.errors.fees"
                    />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Total do Pedido</label>
                    <input
                        type="text"
                        class="form-control"
                        :value="total.toFixed(2)"
                        readonly
                    />
                </div>
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="observation">Observações</label>
            <textarea
                id="observation"
                v-model="form.observation"
                class="form-control"
                :class="{ 'is-invalid': form.errors.observation }"
                rows="3"
            ></textarea>
            <div class="invalid-feedback">
                {{ form.errors.observation }}
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button
                type="submit"
                class="btn btn-primary"
                :disabled="form.processing"
            >
                <span
                    v-if="form.processing"
                    class="spinner-border spinner-border-sm mr-2"
                    role="status"
                    aria-hidden="true"
                ></span>
                <span v-if="form.processing">Salvando...</span>
                <span v-else>
                    <i class="fas fa-save"></i>
                    &nbsp;
                    {{ props.order ? "Atualizar Pedido" : "Criar Pedido" }}
                </span>
            </button>
        </div>
    </form>
</template>
