<template>
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Psicólogo
        </h2>
      </template>
      
      <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Atestado Médico</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-gray-700">Eu Doutor(a)</label>
            <input type="text" v-model="doctorName" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-gray-700">Atesto que o(a) paciente</label>
            <input type="text" v-model="patientName" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-gray-700">Encontra-se inapto(a) para atividades</label>
            <input type="text" v-model="duration" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>
          <div>
            <label class="block text-gray-700">Motivo</label>
            <textarea v-model="reason" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>
          </div>
          <div class="text-center">
            <button @click="generatePDF" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Imprimir</button>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { PDFDocument, rgb, StandardFonts } from 'pdf-lib';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  const doctorName = ref('');
  const patientName = ref('');
  const duration = ref('');
  const reason = ref('');
  
  const generatePDF = async () => {
  const pdfDoc = await PDFDocument.create();
  const page = pdfDoc.addPage([600, 400]);

  // Add custom font
  const font = await pdfDoc.embedFont(StandardFonts.Helvetica);
  const titleFont = await pdfDoc.embedFont(StandardFonts.HelveticaBold);

  // Add title
  const title = 'Atestado Médico';
  page.drawText(title, {
    x: 50,
    y: 370,
    size: 18,
    font: titleFont,
    color: rgb(0.2, 0.2, 0.7),
  });

  // Add horizontal line
  page.drawLine({
    start: { x: 50, y: 365 },
    end: { x: 550, y: 365 },
    thickness: 1,
    color: rgb(0.8, 0.8, 0.8),
  });

  // Add text content
  const textContent = [
    `Eu Doutor ${doctorName.value} Atesto que o(a) paciente ${patientName.value}`,
    `Encontra-se inapto(a) para atividades ${duration.value} Pelo Motivo:`,
    `${reason.value}`,
  ];

  textContent.forEach((text, idx) => {
    page.drawText(text, {
      x: 50,
      y: 340 - (idx * 20),
      size: 12,
      font,
      color: rgb(0, 0, 0),
    });
  });

  // Add footer
  const footerText = 'Assinatura do Médico';
  page.drawText(footerText, {
    x: 50,
    y: 50,
    size: 12,
    font,
    color: rgb(0, 0, 0),
  });

  // Save PDF
  const pdfBytes = await pdfDoc.save();
  const blob = new Blob([pdfBytes], { type: 'application/pdf' });
  const link = document.createElement('a');
  link.href = URL.createObjectURL(blob);
  link.download = 'atestado_medico.pdf';
  link.click();
};
  </script>
  