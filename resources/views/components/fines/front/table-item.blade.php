<tr wire:key="fine-{{ $fine->id }}">
    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
        <div class="font-medium text-gray-800 dark:text-white truncate first-letter:uppercase">{{ $fine->loan?->serial ?? '---' }}</div>
        <span class="inline-block mt-0.5 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'prestamo-' . $fine->loan->status) }}">
            {{ App\Enums\LoanStatusEnum::options()[$fine->loan?->status] }}
        </span>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <div>$ {{ number_format($fine->loan?->fine_amount, 2, ',', '.') }}</div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <div>{{ $fine->days }}</div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400 font-medium">
        <div>$ {{ number_format($fine->total, 2, ',', '.') }}</div>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 {{ str_replace(' ', '-', 'multa-' . $fine->status) }}">
            {{ App\Enums\FineStatusEnum::options()[$fine->status] }}
        </span>
    </td>

    <td class="px-4 py-4 text-sm whitespace-nowrap text-gray-700 dark:text-gray-400">
        <livewire:front.fine.pay-u-payment-live :fineId="$fine->id" :fineStatus="$fine->status" :loanStatus="$fine->loan->status" />
    </td>
</tr>
