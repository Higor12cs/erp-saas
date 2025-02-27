<script setup>
const props = defineProps({
    modelValue: {
        type: [String, Number, Date],
        default: "",
    },
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        default: "",
    },
    type: {
        type: String,
        default: "text",
    },
    placeholder: {
        type: String,
        default: "",
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

const emit = defineEmits(["update:modelValue"]);
</script>

<template>
    <div class="form-group">
        <label :for="id" v-if="label">
            {{ label }} <span v-if="required" class="text-danger">*</span>
        </label>
        <input
            :type="type"
            class="form-control"
            :class="{ 'is-invalid': error }"
            :id="id"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :required="required"
        />
        <div v-if="error" class="invalid-feedback">
            {{ error }}
        </div>
    </div>
</template>
