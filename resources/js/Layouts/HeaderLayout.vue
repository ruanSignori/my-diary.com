<script setup lang="ts">
import { Icon } from '@iconify/vue';
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import DropdownItem from '@/Components/DropdownItem.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-bg">
            <nav
                class="border-b border-zinc-300 bg- shadow-sm"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('home')"
                                    :active="route().current('home')"
                                >
                                    Home
                                </NavLink>

                                <template v-if="route().current('posts.show')">
                                    <NavLink
                                        :href="route('posts.index')"
                                        :active="route().current('posts.show')"
                                    >
                                        Post
                                    </NavLink>
                                </template>
                            </div>
                        </div>

                        <div class="hidden-6 sm:flex sm:items-center">
                            <!-- Conditional: User Logged In -->
                            <template v-if="$page.props.auth.user">
                                <!-- Settings Dropdown -->

                                <Link
                                  :href="route('posts.create')"
                                >
                                  <PrimaryButton>
                                    <Icon icon="ri:add-fill" width="18" height="18" />
                                    Post
                                  </PrimaryButton>
                                </Link>

                                <div class="relative ms-3">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                                >
                                                    {{$page.props.auth.user.name}}
                                                    <Icon icon="ri:arrow-down-s-line" width="18" height="18" />
                                                </button>

                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownItem
                                                :href="route('profile.edit')"
                                            >
                                                Profile
                                            </DropdownItem>
                                            <DropdownItem
                                                :href="route('logout')"
                                                method="post"
                                                as="button"
                                            >
                                                Log Out
                                            </DropdownItem>
                                        </template>
                                    </Dropdown>
                                </div>
                            </template>

                            <!-- Conditional: User Not Logged In -->
                            <template v-else>
                              <div class="flex gap-2">
                                <Link :href="route('login')">
                                  <PrimaryButton>Entrar</PrimaryButton>
                                </Link>
                                <Link :href="route('register')">
                                  <SecondaryButton>Cadastrar</SecondaryButton>
                                </Link>
                              </div>
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                              <Icon icon="ri:menu-fill" width="24" height="24" />
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            Home
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <template v-if="$page.props.auth.user">
                            <div class="px-4">
                                <div
                                    class="text-base font-medium text-gray-800"
                                >
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.edit')"
                                >
                                    Profile
                                </ResponsiveNavLink>
                                <ResponsiveNavLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </ResponsiveNavLink>
                            </div>
                        </template>

                        <template v-else>
                            <ResponsiveNavLink :href="route('login')">
                                Login
                            </ResponsiveNavLink>
                        </template>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
