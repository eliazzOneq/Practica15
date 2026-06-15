import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const HomeView = () => import('../views/HomeView.vue')
const CatalogoView = () => import('../views/CatalogoView.vue')
const ProductoDetalleView = () => import('../views/ProductoDetalle.vue')
const LoginView = () => import('../views/LoginView.vue')
const NotFoundView = () => import('../views/NotFound.vue')
const CartView = () => import('../views/CartView.vue')
const RegisterView = () => import('../views/RegisterView.vue')

const AdminLayout = () => import('../layouts/AdminLayout.vue')
const DashboardView = () => import('../views/admin/AdminDashboard.vue')
const ProductosAdminView = () => import('../views/admin/AdminProductos.vue')

const routes = [
  {
    path: '/',
    component: HomeView
  },

  {
    path: '/catalogo',
    component: CatalogoView
  },

  {
    path: '/catalogo/:id',
    component: ProductoDetalleView
  },

  {
    path: '/register',
    component: RegisterView
  },

  {
    path: '/login',
    component: LoginView
  },

  {
    path: '/carrito',
    component: CartView
  },

  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },

    children: [
      {
        path: '',
        component: DashboardView
      },

      {
        path: 'productos',
        component: ProductosAdminView
      }
    ]
  },

  {
    path: '/:pathMatch(.*)*',
    component: NotFoundView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.autenticado) {
    return `/login?redirect=${to.fullPath}`
  }
})

export default router