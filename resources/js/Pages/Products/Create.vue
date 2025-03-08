<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import InputField from "@/Components/InputField.vue";
import Select2 from "@/Components/Select2.vue";

const form = useForm({
    brand_id: null,
    group_id: null,
    name: "",
    description: "",
    sku: "",
    cost: "",
    price: "",
});

const submit = () => {
    form.post(route("products.store"));
};
</script>

<template>
    <Head title="Criar Produtos" />
    <AuthenticatedLayout>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>Criar Produtos</h4>
                <Breadcrumb
                    :breadcrumb="[
                        { label: 'Home', routeName: 'home.index' },
                        { label: 'Produtos', routeName: 'products.index' },
                        { label: 'Criar' },
                    ]"
                />
            </div>
            <Link
                :href="route('products.index')"
                class="btn btn-secondary mb-auto"
            >
                <i class="fas fa-sm fa-arrow-left"></i>
                &nbsp; Voltar
            </Link>
        </div>
        <div class="card">
            <div class="card-header">Cadastro de Produtos</div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="col-12">
                            <InputField
                                id="name"
                                label="Nome"
                                v-model="form.name"
                                :error="form.errors.name"
                                required
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <InputField
                                id="description"
                                label="Descrição"
                                v-model="form.description"
                                :error="form.errors.description"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <Select2
                                label="Grupo"
                                v-model="form.group_id"
                                :error="form.errors.group_id"
                                :search-url="route('api.groups.search')"
                                value-key="id"
                                label-key="name"
                                placeholder="Pesquisar"
                            />
                        </div>

                        <div class="col-6">
                            <Select2
                                label="Marca"
                                v-model="form.brand_id"
                                :error="form.errors.brand_id"
                                :search-url="route('api.brands.search')"
                                value-key="id"
                                label-key="name"
                                placeholder="Pesquisar"
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <InputField
                                id="sku"
                                label="SKU"
                                v-model="form.sku"
                                :error="form.errors.sku"
                            />
                        </div>
                        <div class="col-md-4">
                            <InputField
                                id="cost"
                                label="Custo"
                                v-model="form.cost"
                                :error="form.errors.cost"
                                required
                            />
                        </div>
                        <div class="col-md-4">
                            <InputField
                                id="price"
                                label="Preço"
                                v-model="form.price"
                                :error="form.errors.price"
                                required
                            />
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
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
                                &nbsp; Salvar
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
