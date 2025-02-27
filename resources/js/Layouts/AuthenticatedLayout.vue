<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import { onMounted } from "vue";
import NavItem from "@/Components/NavItem.vue";
import NavItemCollapsible from "@/Components/NavItemCollapsible.vue";

const currentTime = ref("");

const sidebarItems = ref([
    {
        type: "header",
        label: "Início",
    },
    {
        type: "link",
        routeName: "home.index",
        iconClass: "fas fa-home",
        label: "Home",
        permission: "home.view",
    },
    {
        type: "link",
        routeName: "dashboard.index",
        iconClass: "fas fa-tachometer-alt",
        label: "Dashboard",
        permission: "dashboard.view",
    },
    {
        type: "header",
        label: "Cadastros",
    },
    {
        type: "collapsible",
        iconClass: "fas fa-users",
        label: "Cadastros",
        permission: "cadastros.view",
        subItems: [
            {
                routeName: "customers.index",
                iconClass: "fas fa-users",
                label: "Clientes",
                permission: "customers.view",
            },
            {
                routeName: "suppliers.index",
                iconClass: "fas fa-users",
                label: "Fornecedores",
                permission: "suppliers.view",
            },
            {
                routeName: "users.index",
                iconClass: "fas fa-users",
                label: "Usuários",
                permission: "users.view",
            },
        ],
    },
    {
        type: "header",
        label: "Estoque",
    },
    {
        type: "link",
        routeName: "products.index",
        iconClass: "fas fa-boxes",
        label: "Produtos",
        permission: "products.view",
    },
]);

const hasPermission = (permission) => {
    return true;
};

const updateTime = () => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");
    const seconds = String(now.getSeconds()).padStart(2, "0");
    currentTime.value = `${hours}:${minutes}:${seconds}`;
};

onMounted(() => {
    updateTime();
    setInterval(updateTime, 1000);
});
</script>

<template>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-widget="pushmenu"
                        href="#"
                        role="button"
                    >
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    {{ currentTime }}
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ $page.props.auth.user.name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="dropdown-item"
                        >
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Sair
                        </Link>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-2">
            <Link href="/" class="brand-link d-flex justify-content-center">
                <span class="brand-text font-weight-semibold">AdminLTE</span>
            </Link>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul
                        class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false"
                    >
                        <template
                            v-for="(item, index) in sidebarItems"
                            :key="index"
                        >
                            <!-- Header item -->
                            <li
                                v-if="item.type === 'header'"
                                class="nav-header"
                            >
                                {{ item.label }}
                            </li>

                            <!-- Regular -->
                            <NavItem
                                v-else-if="
                                    item.type === 'link' &&
                                    (!item.permission ||
                                        hasPermission(item.permission))
                                "
                                :route-name="item.routeName"
                                :icon-class="item.iconClass"
                                :label="item.label"
                            />

                            <!-- Collapsible -->
                            <NavItemCollapsible
                                v-else-if="
                                    item.type === 'collapsible' &&
                                    (!item.permission ||
                                        hasPermission(item.permission))
                                "
                                :icon-class="item.iconClass"
                                :label="item.label"
                                :sub-items="
                                    item.subItems.filter(
                                        (subItem) =>
                                            !subItem.permission ||
                                            hasPermission(subItem.permission)
                                    )
                                "
                            />
                        </template>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid pt-3">
                    <slot />
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
</template>
