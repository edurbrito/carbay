Showing {{ $auctions->perPage() * ($auctions->currentPage()-1) + 1}} 
            to {{$auctions->perPage() * ($auctions->currentPage()-1) + $auctions->count()}} 
            of {{$auctions->total()}} Auctions