@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-title">All Products</div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        <form method="GET" action="{{ route('products.index') }}" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, unit..." style="padding:7px 10px;border:1px solid var(--border);border-radius:3px;font-size:.85rem;background:var(--bg);color:var(--text);width:260px">
            <button type="submit" class="btn btn-secondary">Search</button>
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Product Name</th><th>Unit</th><th>Unit Price</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($products as $p)
            <tr>
                <td>{{ $p->product_ID }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->p_unit }}</td>
                <td>PHP {{ number_format($p->unit_price, 2) }}</td>
                <td>
                    <a href="{{ route('products.edit', $p->product_ID) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $p->product_ID) }}" style="display:inline" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="color:var(--muted)">{{ request('search') ? 'No products matched your search.' : 'No products found.' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;font-size:.85rem;color:var(--muted)">
        <span>
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
        </span>
        <div style="display:flex;gap:6px">
            {{-- Previous --}}
            @if($products->onFirstPage())
                <span style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;color:var(--muted);cursor:not-allowed">← Prev</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;color:var(--text);text-decoration:none">← Prev</a>
            @endif

            {{-- Page numbers --}}
            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if($page == $products->currentPage())
                    <span style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;background:var(--primary,#7c3a1e);color:#fff;font-weight:600">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;color:var(--text);text-decoration:none">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;color:var(--text);text-decoration:none">Next →</a>
            @else
                <span style="padding:5px 10px;border:1px solid var(--border);border-radius:3px;color:var(--muted);cursor:not-allowed">Next →</span>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection