<span wire:click="toggleShare" style="cursor:pointer">
    <i class="bx {{ $isShared ? 'bxs-share' : 'bx-share' }}"></i>
    {{ $model->shares()->count() }}
</span>
