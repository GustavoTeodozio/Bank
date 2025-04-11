<x-layouts.app :title="__('Dashboard')">

    <div class="filament-main-content p-4 space-y-8">
        <div class="filament-header mb-4">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>

        <div class="filament-widgets grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="filament-widget bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-medium">Saldo Atual</h2>
                <p class="text-2xl font-bold text-green-600">
                    R$ {{ number_format($saldo['balance'], 2, ',', '.') }}
                </p>
            </div>

            <div class="filament-widget bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-medium">Bem-vindo</h2>
                <p>Olá, {{ $nome }}</p>
            </div>
        </div>


        {{-- Linha de Diálogo da IA Financeira --}}
        <div class="filament-widget bg-blue-50 border border-blue-200 rounded-lg shadow p-4 mt-6">
            <h2 class="text-lg font-medium text-blue-700 mb-2">💡 Sugestão da IA Financeira</h2>
            <p class="text-gray-700 mb-4">
                Detectamos recentemente que você vem gastando bastante. Gostaria de fazer uma análise para reduzir seus
                gastos e assim sobrar mais dinheiro no fim do mês?
            </p>
            <div class="flex space-x-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Sim, quero
                    analisar</button>
                <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">Não,
                    obrigado</button>
            </div>
        </div>

        {{-- Tabela de Últimas Transferências --}}
        <div class="filament-widget bg-white rounded-lg shadow p-4 mt-6">
            <h2 class="text-lg font-medium mb-4">Últimas Transferências</h2>
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="border-b p-2 text-left">Data</th>
                        <th class="border-b p-2 text-left">Descrição</th>
                        <th class="border-b p-2 text-left">Valor</th>
                        <th class="border-b p-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border-b p-2">2025-04-01</td>
                        <td class="border-b p-2">Transferência para João</td>
                        <td class="border-b p-2 text-green-600">R$ 100,00</td>
                        <td class="border-b p-2">Concluído</td>
                    </tr>
                    <tr>
                        <td class="border-b p-2">2025-03-31</td>
                        <td class="border-b p-2">Recebimento de Maria</td>
                        <td class="border-b p-2 text-green-600">R$ 150,00</td>
                        <td class="border-b p-2">Concluído</td>
                    </tr>
                    <tr>
                        <td class="border-b p-2">2025-03-30</td>
                        <td class="border-b p-2">Pagamento de Conta</td>
                        <td class="border-b p-2 text-red-600">R$ 50,00</td>
                        <td class="border-b p-2">Concluído</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>