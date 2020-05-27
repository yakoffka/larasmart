<?php
$device ??= new \App\Device();
$id = 'add_device_' . $device->hid;
?>

<!-- Button trigger modal -->
<a class="cursor_pointer" data-toggle="modal" data-target="#<?= $id ?>">
    <i class="fas fa-save blue"></i>
</a>

<!-- Modal -->
<div class="modal fade" id="<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="<?= $id ?>Title"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Adding {{ $device->hid }} device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><a class="modal_close_yo" href="/">&times;</a></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="{{ $id }}_form" action="{{ route('devices.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="hid" value="{{ $device->hid ?? '' }}">
                    <input type="hidden" name="number_relay" value="{{ $device->number_relay ?? '' }}">
                    <input type="text" name="name" placeholder="enter device name" required
                           value="{{ old('name') ?? $device->name ??  $device->hid }}">
                    <input type="text" name="description" placeholder="enter device description"
                           value="{{ old('description') ?? $device->description ?? '' }}">
                </form>
            </div>
            <div class="modal-footer">
                <button form="{{ $id }}_form" type="button" class="btn cancel_b" data-dismiss="modal">
                    <a class="modal_close_yo" href="/">
                        cancel
                    </a>
                </button>
                <input form="{{ $id }}_form" type="submit" class="btn btn-primary yo_submit" value="add device">
            </div>
        </div>
    </div>
</div>
