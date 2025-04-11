<x-layouts.app :title="__('Dashboard')">

    <div class="max-w-3xl mx-auto p-6 space-y-6">
        {{-- Título da Página --}}
        <h1 class="text-3xl font-bold text-center">Área PIX</h1>

        {{-- Saldo Atual --}}
        <div class="bg-white shadow rounded-2xl p-6 text-center">
            <p class="text-gray-500">Seu saldo atual</p>
            <p class="text-3xl font-semibold text-green-600 mt-2">R$ {{ $saldo }}</p>
        </div>
        

        {{-- Seção de Transferência --}}
        <div class="flex items-center justify-between bg-white shadow rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-gray-800">Transferir valores</h2>

            {{-- Botão que abre o modal --}}
            <flux:modal.trigger name="enviar-pix">
                <button class="bg-blue-600 text-gray-800 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Transferir
                </button>
            </flux:modal.trigger>
        </div>

        {{-- Modal de Envio PIX --}}
        <flux:modal name="enviar-pix" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Transferir Pix</flux:heading>
                    <flux:text class="mt-2">Informe os dados do destinatário e o valor.</flux:text>
                </div>

                <flux:input label="Chave Pix" placeholder="E-mail, CPF ou telefone" />

                <flux:input label="Valor" type="number" placeholder="Ex: 150.00" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">
                        Confirmar Envio
                    </flux:button>
                </div>
            </div>
        </flux:modal>
        {{-- Seção de Pix Copia e Cola --}}
        <div class="flex items-center justify-between bg-white shadow rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-gray-800">Pix Copia e Cola</h2>

            {{-- Botão que abre o modal --}}
            <flux:modal.trigger name="pix-copia-e-cola">
                <button class="bg-blue-600 text-gray-800 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Colar Código
                </button>
            </flux:modal.trigger>
        </div>

        {{-- Modal de Pix Copia e Cola --}}
        <flux:modal name="pix-copia-e-cola" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Pix Copia e Cola</flux:heading>
                    <flux:text class="mt-2">Cole o código do Pix e confirme o envio.</flux:text>
                </div>

                <flux:textarea label="Código Pix" placeholder="Cole aqui o código completo" />

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">
                        Confirmar Envio
                    </flux:button>
                </div>
            </div>
        </flux:modal>


        {{-- Histórico Simulado --}}
        <div class="bg-white shadow rounded-2xl p-6">
            <h2 class="text-xl font-semibold mb-4">Últimas movimentações</h2>

            <ul class="divide-y divide-gray-200 text-sm">
                <li class="py-2 flex justify-between">
                    <span>Recebido de João</span>
                    <span class="text-green-600 font-medium">+ R$ 200,00</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span>Enviado para Maria</span>
                    <span class="text-red-600 font-medium">- R$ 150,00</span>
                </li>
                <li class="py-2 flex justify-between">
                    <span>Pix para Loja XPTO</span>
                    <span class="text-red-600 font-medium">- R$ 80,00</span>
                </li>
            </ul>
        </div>
    </div>

</x-layouts.app>