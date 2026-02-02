<div class="table-responsive">
    <table class="table table-bordered table-hover tab-pricing">
        <thead class="thead-light">
            <tr>
                <th style="width: 20%">{{ __('main.nationality') }}</th>
                <th class="text-center" style="width: 20%">Adult (12+)</th>
                <th class="text-center" style="width: 20%">Child (2-12)</th>
                <th class="text-center" style="width: 20%">Infant (0-2)</th>
                <th style="width: 20%">{{ __('main.notes') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach(['foreigner', 'arab', 'resident'] as $nat)
                <tr>
                    <td class="font-weight-bold text-capitalize">
                        <span class="kt-badge kt-badge--dot kt-badge--{{ $nat === 'foreigner' ? 'primary' : ($nat === 'arab' ? 'success' : 'warning') }}"></span>
                        {{ $nat }}
                    </td>
                    
                    <!-- Adult -->
                    <td class="text-center">
                        @if(isset($seasonData['adult'][$nat]['cost']))
                            <span class="font-weight-bold text-dark display-5 d-block">{{ $seasonData['adult'][$nat]['cost'] }}</span>
                            @if(isset($seasonData['adult'][$nat]['commission']) && $seasonData['adult'][$nat]['commission'] == 1)
                                <span class="badge badge-sm badge-success mt-1">Comm</span>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <!-- Child -->
                    <td class="text-center">
                        @if(isset($seasonData['child'][$nat]['cost']))
                            <span class="font-weight-bold text-dark d-block">{{ $seasonData['child'][$nat]['cost'] }}</span>
                            @if(isset($seasonData['child'][$nat]['commission']) && $seasonData['child'][$nat]['commission'] == 1)
                                <span class="badge badge-sm badge-success mt-1">Comm</span>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <!-- Infant -->
                    <td class="text-center">
                         @if(isset($seasonData['infant'][$nat]['cost']))
                            <span class="font-weight-bold text-dark d-block">{{ $seasonData['infant'][$nat]['cost'] }}</span>
                            @if(isset($seasonData['infant'][$nat]['commission']) && $seasonData['infant'][$nat]['commission'] == 1)
                                <span class="badge badge-sm badge-success mt-1">Comm</span>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <!-- Notes -->
                    <td>
                        <small class="text-muted">{{ $seasonData['notes'][$nat] ?? '-' }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
