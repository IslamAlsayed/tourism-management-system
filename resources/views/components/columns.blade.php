<div id="parentColumnsModal">
    <div id="columns" data-target-button="#columnsModal"
        class="columns kt-btn kt-btn-outline bg-secondary text-white px-3 h-[45px] cursor-default">
        <i class="fas fa-list"></i>
    </div>
    @include('components.model-columns', ['allColumns' => $allColumns])
</div>
