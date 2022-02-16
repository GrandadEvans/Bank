<template>
    <div
        aria-hidden="true"
        aria-labelledby="exampleModalLabel"
        class="modal fade"
        role="alertdialog"
        tabindex="-1"
        :id="id"
    >

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="modal-header">
                            Modal Title
                        </slot>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <slot name="modal-body">
                        Modal Body
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "bank-modal-base",
    props: [
        'id'
    ]
}
</script>
