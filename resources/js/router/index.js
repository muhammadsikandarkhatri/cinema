import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/login");
    }
};

const routes = [
    {
        path: '/',
        redirect: '/films'
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("../views/Auth/Login.vue")
    },
    {
        path: "/register",
        name: "Register",
        component: () =>
            import("../views/Auth/Register.vue")
    },
    {
        path: "/profile",
        name: "Profile",
        beforeEnter: auth,
        component: () => import("../views/Auth/Profile.vue")
    },
    {
        path: "/films",
        name: "Films",
        component: () => import("../views/Films/Index.vue")
    },
    {
        path: "/films/create",
        name: "Create a Film",
        beforeEnter: auth,
        component: () => import("../views/Films/Create.vue")
    },
    {
        path: "/films/:slug",
        name: "Film Detail",
        props: true,
        component: () => import("../views/Films/Detail.vue")
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.APP_URL,
    routes
});

export default router;
