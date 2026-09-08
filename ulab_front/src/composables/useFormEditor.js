import { ref } from "vue";

export function useFormEditor() {

    const editDialog = ref(false);
    const selectedForm = ref(null);
    const editedFields = ref([]);

    const openEditForm = (form) => {
        selectedForm.value = form;

        const systemFields = (form.fields || []).map((field) => ({
            ...field,

            is_system: true,

            is_new: false,
        }));

        const customFields = (form.custom_fields || []).map((field) => ({
            ...field,

            is_system: false,

            is_new: false,
        }));

        editedFields.value = [...systemFields, ...customFields];

        editDialog.value = true;
    };

    const closeEditForm = () => {
        editDialog.value = false;

        selectedForm.value = null;

        editedFields.value = [];
    };

    const getEmptyField = () => ({
        type_field: "text",

        title_field: "",

        name_field: "",

        size_field: "",

        precission_field: "",

        is_required: false,

        is_visible: true,
    });

    return {
        editDialog,
        selectedForm,
        editedFields,
        openEditForm,
        closeEditForm,
        getEmptyField,
    };
}