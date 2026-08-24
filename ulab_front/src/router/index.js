import { createRouter, createWebHistory } from 'vue-router'
import Base from '../components/base/Base.vue'
import WorkArea from '../components/base/WorkArea.vue'
import AdminPanel from '../components/admin_panel/AdminPanel.vue'
import ModulesSettings from '../components/admin_panel/ModulesSettings.vue'
import RequestForm from '../components/request/RequestForm.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      component: Base,
      children: [
        {
          path: "",
          name: "dashboard",
          component: WorkArea
        },
        {
          path: "request",
          children: [
            {
              path: "new",
              component: RequestForm
            }
          ]
        },
        {
          path: "admin",
          name: "admin",
          component: AdminPanel,
          children: [
            {
              path: "modules",
              component: ModulesSettings
            }
          ]
        },

      ]
    },
  ],
})

export default router
