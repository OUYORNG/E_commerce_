<template>
  <div class="flex flex-col justify-center items-center">
    <!-- Professional Receipt Content -->
    <div id="receipt-content" class="max-w-2xl mx-auto p-4 border border-gray-300 bg-gray-50">
      <!-- Header -->
      <div class="flex gap-10 mb-8 items-center">
        <img src="/public/E_commerce logo.jpg" alt="Logo" class="h-12 max-w-full object-contain rounded-xl" />
        <div>
          <h1 class="text-4xl font-semibold text-gray-800">Receipt</h1>
          <p class="font-bold text-lg">TeamB1 Ecommerce</p>
          <p class="text-sm text-gray-600">123 Institute of Technology of Cambodia, ToulKok, Phnom Penh</p>
          <p class="text-sm text-gray-600">+855 81 26 81 66</p>
        </div>
      </div>

      <!-- Date -->
      <div class="mb-4">
        <p class="font-semibold"><strong>Date:</strong> {{ new Date().toLocaleDateString() }}</p>
      </div>

      <!-- Customer Info -->
      <div class="mb-6">
        <p class="font-semibold"><strong>Email:</strong> user@example.com</p>
        <p class="font-semibold"><strong>Phone:</strong> +855 81 26 81 66</p>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
          <thead>
            <tr>
              <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-semibold">Item</th>
              <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-semibold">Qty</th>
              <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-semibold">Price</th>
              <th class="px-4 py-2 border-b border-gray-300 text-left text-sm font-semibold">Total</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="px-4 py-2 border-b border-gray-300">Laptop</td>
              <td class="px-4 py-2 border-b border-gray-300">1</td>
              <td class="px-4 py-2 border-b border-gray-300">$999.99</td>
              <td class="px-4 py-2 border-b border-gray-300">$999.99</td>
            </tr>
            <tr>
              <td class="px-4 py-2 border-b border-gray-300">Mouse</td>
              <td class="px-4 py-2 border-b border-gray-300">2</td>
              <td class="px-4 py-2 border-b border-gray-300">$25.00</td>
              <td class="px-4 py-2 border-b border-gray-300">$50.00</td>
            </tr>
            <tr class="bg-gray-100">
              <td colspan="3" class="px-4 py-2 text-right font-semibold">Total</td>
              <td class="px-4 py-2 font-semibold">$1049.99</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Footer -->
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">Thank you for your purchases!</p>
        <p class="text-xs text-gray-500 mt-2">This is a computer-generated document and does not require a signature.</p>
      </div>
    </div>

    <!-- Button to generate PDF -->
    <button @click="generatePDF" class="w-2/4 md:w-1/4 mt-6 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none">
      Download Receipt
    </button>
  </div>
</template>

<script>
import html2pdf from "html2pdf.js";

export default {
  name: "Receipt",
  data() {
    return {
      user: "user@example.com",
      items: [
        { name: "Laptop", qty: 1, price: 999.99, total: 999.99 },
        { name: "Mouse", qty: 2, price: 25.00, total: 50.00 }
      ]
    };
  },
  computed: {
    totalAmount() {
      return this.items.reduce((total, item) => total + item.total, 0).toFixed(2);
    },
  },
  methods: {
    generatePDF() {
      const element = document.getElementById("receipt-content");

      const options = {
        margin: 10,
        filename: `receipt_${new Date().getTime()}.pdf`,
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
      };

      html2pdf().set(options).from(element).save();
    },
  },
};
</script>

<style scoped>
/* Tailwind CSS already handles most of the styling, so custom styles are not necessary here */
</style>
