<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import InputField from "@/Components/InputField.vue";
import SearchSelect from "@/Components/SearchSelect.vue";

defineProps({
    sections: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    section_id: null,
    name: "",
});

const submit = () => {
    form.post(route("groups.store"));
};

function handleSectionChange(value) {
    console.log("Seção:", value);
}
</script>

<template>
    <Head title="Criar Grupos" />
    <AuthenticatedLayout>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <h4>Criar Grupos</h4>
                <Breadcrumb
                    :breadcrumb="[
                        { label: 'Home', routeName: 'home.index' },
                        { label: 'Seções', routeName: 'groups.index' },
                        { label: 'Criar' },
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
            <div class="card-header">Cadastro de Grupos</div>
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
                            <SearchSelect
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
