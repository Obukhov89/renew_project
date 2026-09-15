import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import { ru } from 'vuetify/locale'; // ✅ Импорт русской локали
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components'; // ✅ Импорт компонентов
import * as directives from 'vuetify/directives'; // ✅ Импорт директив

export default createVuetify({
    components, // ✅ Подключение компонентов
    directives, // ✅ Подключение директив
    theme: {
        defaultTheme: 'light',
    },
    locale: {
        locale: 'ru', // ✅ Устанавливаем русский язык
        messages: { ru }, // ✅ Подключаем переводы
    },
});