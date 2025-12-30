@php
    $items = $self->getRelatedItems();
    $displayAttribute = $self->displayAttribute;
    $limit = $self->limit;
    $total = count($items);
    $displayItems = array_slice($items, 0, $limit);
    $remaining = $total - $limit;
@endphp
<td>
    <div class="d-flex flex-wrap gap-1">
        @forelse($displayItems as $item)
            <span class="badge bg-blue-lt">{{ $item[$displayAttribute] ?? $item['name'] ?? '-' }}</span>
        @empty
            <span class="text-muted">-</span>
        @endforelse
        @if($remaining > 0)
            <span class="badge bg-secondary-lt" title="{{ $total }} total">+{{ $remaining }}</span>
        @endif
    </div>
</td>
