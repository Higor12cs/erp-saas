<script setup>
import { ref, computed, onMounted, watch } from "vue";
import axios from "axios";

const props = defineProps({
    modelValue: {
        type: [String, Number, Object],
        default: null,
    },
    label: {
        type: String,
        default: "Selecione",
    },
    placeholder: {
        type: String,
        default: "Pesquisar...",
    },
    searchUrl: {
        type: String,
        required: true,
    },
    valueKey: {
        type: String,
        default: "id",
    },
    labelKey: {
        type: String,
        default: "name",
    },
    required: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue", "change"]);

const searchTerm = ref("");
const options = ref([]);
const isDropdownOpen = ref(false);
const isLoading = ref(false);
const selectedOption = ref(null);
const highlightedIndex = ref(-1);
const inputRef = ref(null);
const containerRef = ref(null);

const showError = computed(() => props.error && props.error.length > 0);

const searchOptions = async () => {
    if (searchTerm.value.length < 2) {
        options.value = [];
        return;
    }

    try {
        isLoading.value = true;
        const response = await axios.get(props.searchUrl, {
            params: { search: searchTerm.value },
        });
        options.value = response.data;
        highlightedIndex.value = -1;
    } catch (error) {
        console.error("Erro ao buscar dados: ", error);
        options.value = [];
    } finally {
        isLoading.value = false;
    }
};

watch(searchTerm, () => {
    searchOptions();
});

const selectOption = (option) => {
    selectedOption.value = option;
    searchTerm.value = option[props.labelKey];
    emit("update:modelValue", option[props.valueKey]);
    emit("change", option);
    closeDropdown();
};

const openDropdown = () => {
    isDropdownOpen.value = true;
};

const closeDropdown = () => {
    setTimeout(() => {
        isDropdownOpen.value = false;
    }, 150);
};

const handleKeyDown = (e) => {
    if (!isDropdownOpen.value) {
        if (e.key === "ArrowDown" || e.key === "Enter") {
            openDropdown();
            searchOptions();
        }
        return;
    }

    switch (e.key) {
        case "ArrowDown":
            e.preventDefault();
            highlightedIndex.value = Math.min(
                highlightedIndex.value + 1,
                options.value.length - 1
            );
            break;
        case "ArrowUp":
            e.preventDefault();
            highlightedIndex.value = Math.max(highlightedIndex.value - 1, 0);
            break;
        case "Enter":
            e.preventDefault();
            if (
                highlightedIndex.value >= 0 &&
                options.value[highlightedIndex.value]
            ) {
                selectOption(options.value[highlightedIndex.value]);
            }
            break;
        case "Escape":
            e.preventDefault();
            closeDropdown();
            break;
    }
};

const clearSelection = () => {
    selectedOption.value = null;
    searchTerm.value = "";
    emit("update:modelValue", null);
    emit("change", null);
    inputRef.value.focus();
};

onMounted(() => {
    if (props.modelValue) {
        // TODO: Load selected option from API.
    }
});
</script>

<template>
    <div class="form-group" ref="containerRef">
        <label
            v-if="label"
            :for="'search-select-' + label.toLowerCase().replace(' ', '-')"
            class="form-label"
        >
            {{ label }} <span v-if="required" class="text-danger">*</span>
        </label>

        <div class="input-group">
            <input
                :id="'search-select-' + label.toLowerCase().replace(' ', '-')"
                ref="inputRef"
                type="text"
                class="form-control"
                :class="{ 'is-invalid': showError }"
                v-model="searchTerm"
                :placeholder="placeholder"
                @focus="openDropdown"
                @blur="closeDropdown"
                @keydown="handleKeyDown"
                autocomplete="off"
            />

            <div class="input-group-append">
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    @click="clearSelection"
                    v-if="selectedOption"
                >
                    <i class="fas fa-times"></i>
                </button>
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    @click="openDropdown"
                >
                    <i class="fas fa-search" v-if="!isLoading"></i>
                    <i class="fas fa-spinner fa-spin" v-else></i>
                </button>
            </div>

            <div v-if="showError" class="invalid-feedback">
                {{ error }}
            </div>
        </div>

        <!-- Dropdown -->
        <div class="input-group">
            <div
                class="dropdown-menu w-100"
                :class="{
                    show: isDropdownOpen && (options.length > 0 || isLoading),
                }"
                style="
                    max-height: 280px;
                    overflow-y: auto;
                    margin-top: .15rem;
                "
            >
                <div v-if="isLoading" class="dropdown-item text-center">
                    <span
                        class="spinner-border spinner-border-sm mr-2"
                        role="status"
                        aria-hidden="true"
                    ></span
                    >Carregando...
                </div>

                <template v-else>
                    <a
                        v-for="(option, index) in options"
                        :key="option[valueKey]"
                        href=""
                        class="dropdown-item"
                        :class="{ active: index === highlightedIndex }"
                        @mousedown.prevent="selectOption(option)"
                        @mouseover="highlightedIndex = index"
                    >
                        {{ option[labelKey] }}
                    </a>

                    <div
                        v-if="options.length === 0 && searchTerm.length >= 2"
                        class="dropdown-item text-muted"
                    >
                        Nenhum resultado encontrado.
                    </div>

                    <div
                        v-if="searchTerm.length < 2"
                        class="dropdown-item text-muted"
                    >
                        Digite pelo menos 2 caracteres para pesquisar.
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
