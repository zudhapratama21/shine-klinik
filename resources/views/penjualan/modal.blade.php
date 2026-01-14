<div class="modal fade" id="modalproduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="">Qty</label>
                        <input type="number" id="qty" name="qty" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Harga Jual</label>
                        <input type="number" id="harga_jual" name="harga_jual" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Diskon (%)</label>
                        <input type="number" id="diskon_persen" name="diskon_persen" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Diskon Rupiah</label>
                        <input type="number" id="diskon_rupiah" name="diskon_rupiah" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Ongkos Kirim</label>
                        <input type="number" id="ongkir" name="ongkir" class="form-control">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="simpanProduct()" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
