<template>
    <Head title="Cliente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cliente
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-2 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="container mx-auto p-6">
                            <h1 class="text-2xl font-semibold mb-4">Agendar Consulta</h1>
                            <form @submit.prevent="submitForm" class="max-w-md mx-auto">
                            <div class="mb-4">
                                <label for="patients_id" class="block text-sm font-medium text-gray-700">Paciente</label>
                                <input v-model="patientId" id="patients_id" placeholder="ID do Paciente" class="mt-1 p-2 border rounded-md w-full" readonly>
                            </div>
                            <div class="mb-4">
                                <label for="psicologo_id" class="block text-sm font-medium text-gray-700">Psicólogo</label>
                                <input type="text" v-model="psicologoId" id="psicologo_id" placeholder="ID do Psicólogo" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div class="mb-4">
                                <label for="date" class="block text-sm font-medium text-gray-700">Data</label>
                                <input type="date" v-model="date" id="date" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div class="mb-6">
                                <label for="time" class="block text-sm font-medium text-gray-700">Horário</label>
                                <input type="time" v-model="time" id="time" class="mt-1 p-2 border rounded-md w-full">
                            </div>
                            <div v-if="errorMessage" class="text-red-500 mb-4">{{ errorMessage }}</div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agendar</button>
                        </form>

                        </div>
                    </div>
                </div>
                <!-- Lista de Psicólogos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-semibold mb-4">Lista de Psicólogos</h1>
                        <ul>
                            <li v-for="psicologo in psicologos" :key="psicologo.id">
                                {{ psicologo.full_name }} - ID: {{ psicologo.id }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage, useRoute } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

const patientId = window.location.pathname.split('/').pop();
const psicologoId = ref('');
const date = ref('');
const time = ref('');
const errorMessage = ref('');
const successMessage = ref('');
const psicologos = ref([]);

const submitForm = async () => {
    errorMessage.value = '';
    successMessage.value = '';

    // Verificação de disponibilidade
    const isAvailable = await checkAvailability(psicologoId.value, date.value, time.value);
    if (!isAvailable) {
        errorMessage.value = 'Este psicólogo não está disponível neste dia e horário.';
        return;
    }

    // Se o psicólogo estiver disponível, prosseguir com o agendamento
    try {
        const response = await axios.post('/appointments', {
            patients_id: patientId,
            psicologo_id: psicologoId.value,
            date: date.value,
            time: time.value
        });
        
        successMessage.value = 'Consulta agendada com sucesso para o paciente ' + patientId;
        // Limpar os campos após o sucesso
        psicologoId.value = '';
        date.value = '';
        time.value = '';
    } catch (error) {
        console.error(error);
        errorMessage.value = 'Não foi possível agendar a consulta.';
    }
};

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

const checkAvailability = async () => {
    try {
        const response = await axios.get('/checkAvailability');
        return response.data.available;
    } catch (error) {
        console.error('Erro ao verificar disponibilidade do psicólogo:', error);
        return false;
    }
};
</script>
