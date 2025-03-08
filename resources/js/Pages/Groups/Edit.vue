<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import InputField from "@/Components/InputField.vue";
import Select2 from "@/Components/Select2.vue";

const props = defineProps({
    group: Object,
});

const form = useForm({
    _method: "PUT",
    name: props.group.name || "",
    section_id: props.group.section_id || "",
});

const submit = () => {
    form.post(route("groups.update", props.group.id));
};

function handleSectionChange(value) {
    // console.log("Seção:", value);
}
</script>

<template>
    <Head title="Editar Grupo" />
    <AuthenticatedLayout>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>Editar Grupo</h4>
                <Breadcrumb
                    :breadcrumb="[
                        { label: 'Home', routeName: 'home.index' },
                        { label: 'Grupo', routeName: 'groups.index' },
                        { label: 'Editar' },
                    ]"
                />
            </div>
            <Link
                :href="route('groups.index')"
                class="btn btn-secondary mb-auto"
            >
                <i class="fas fa-sm fa-arrow-left"></i>
                &nbsp; Voltar
            </Link>
        </div>
        <div class="card">
            <div class="card-header">Edição de Grupo</div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="col-md-12">
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
                            <Select2
                                label="Seção"
                                v-model="form.section_id"
                                :error="form.errors.section_id"
                                :search-url="route('api.sections.search')"
                                value-key="id"
                                label-key="name"
                                placeholder="Pesquisar"
                                required
                                @change="handleSectionChange"
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
