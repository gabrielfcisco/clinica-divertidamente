<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';
import axios from 'axios';

const showingNavigationDropdown = ref(false);
const form = useForm({});

const patients = ref([]);

const fetchPatients = async () => {
    try {
        const response = await axios.get('/api/patients');
        patients.value = response.data;
    } catch (error) {
        console.error('Erro ao buscar pacientes:', error);
    }
};

onMounted(() => {
    fetchPatients();
});

const psicologos = ref([]);

const fetchPsychologists = async () => {
  try {
    const response = await axios.get('/api/psicologos');
    psicologos.value = response.data;
  } catch (error) {
    console.error('Erro ao buscar psicólogos:', error);
  }
};

onMounted(() => {
  fetchPsychologists();
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <template v-if="$page.props.auth.user">
                                    <template v-if="$page.props.auth.user.role === 'secretaria'">
                                        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                            Dashboard
                                        </NavLink>
                                    </template>
                                    <template v-else-if="$page.props.auth.user.role === 'patient'">
                                        <template v-for="patient in patients" :key="patient.id">
                                            <NavLink :href="route('patient.index2', { id: patient.id })" :active="route().current('patient.index2')">
                                                Patient
                                            </NavLink>
                                        </template>
                                    </template>
                                    <template v-else-if="$page.props.auth.user.role === 'psicologo'">
                                        <template v-for="psicologo in psicologos" :key="psicologo.id">
                                            <NavLink :href="route('psychologist.index2', { id: psicologo.id })" :active="route().current('psychologist.index2')">
                                                Psychologist
                                            </NavLink>
                                        </template>
                                    </template>
                                </template>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink as="button" @click="form.post(route('logout'))">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <template v-if="$page.props.auth.user">
                            <template v-if="$page.props.auth.user.role === 'secretaria'">
                                <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </ResponsiveNavLink>
                            </template>
                            <template v-else-if="$page.props.auth.user.role === 'patient'">
                                <template v-for="patient in patients" :key="patient.id">
                                    <ResponsiveNavLink :href="route('patient.index2', { id: patient.id })" :active="route().current('patient.index2')">
                                        Patient
                                    </ResponsiveNavLink>
                                </template>
                            </template>
                            <template v-else-if="$page.props.auth.user.role === 'psicologo'">
                                <template v-for="psicologo in psicologos" :key="psicologo.id">
                                    <ResponsiveNavLink :href="route('psychologist.index2', { id: psicologo.id })" :active="route().current('psychologist.index2')">
                                        Psychologist
                                    </ResponsiveNavLink>
                                </template>
                            </template>
                        </template>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink as="button" @click="form.post(route('logout'))">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
