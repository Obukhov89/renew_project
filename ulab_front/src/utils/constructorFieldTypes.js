// данные необходимые для передачи типов при добавлении новых полей ввода в форму

export const FIELD_TYPES = [
    {
        title: "Текст",
        value: "text",
        icon: "mdi-form-textbox",
    },
    {
        title: "Число",
        value: "number",
        icon: "mdi-numeric",
    },
    {
        title: "E-mail",
        value: "email",
        icon: "mdi-email-outline",
    },
    {
        title: "Телефон",
        value: "tel",
        icon: "mdi-phone-outline",
    },
    {
        title: "Выпадающий список",
        value: "select",
        icon: "mdi-form-select",
    },
    {
        title: "Дата",
        value: "date",
        icon: "mdi-calendar-outline",
    },
    {
        title: "Многострочный текст",
        value: "textarea",
        icon: "mdi-text-box-outline",
    },
    {
        title: "Флажок",
        value: "checkbox",
        icon: "mdi-checkbox-outline",
    },
    {
        title: "Файл",
        value: "file",
        icon: "mdi-file-upload-outline",
    },
    {
        title: "Переключатель",
        value: "radio",
        icon: "mdi-radiobox-marked",
    },
];

export const getFieldType = (type) => {
    return FIELD_TYPES.find((item) => item.value === type);
};