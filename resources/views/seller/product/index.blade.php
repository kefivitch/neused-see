@extends("admin/layouts.sellermaster")
@section('title','All Products |')
@section("body")


 <div class="box box-pirmary">
  

      <div class="box-header">
        <h3 class="box-title">All Products</h3>
        <br><br>
        <a title="Import products" href="{{ url('seller/importproducts') }}" class="btn btn-md bg-olive">Import Products</a>
        <a href="{{ url('seller/products/create') }}" class="btn btn-md btn-success">+ Add Product</a>

        <a type="button" class="btn btn-danger btn-md z-depth-0" data-toggle="modal" data-target="#bulk_delete"><i class="fa fa-trash"></i> Delete Selected</a> 

   
        
      </div>




     <div class="box-body">
          <table id="productTable" class="width100 table table-bordered table-hover">
              <thead>
                <th>
                  <div class="inline">
                    <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]" value="all"/>
                    <label for="checkboxAll" class="material-checkbox"></label>
                  </div>
                
                </th>
                <th>
                  #
                </th>
                <th>
                  Image
                </th>

                <th>
                  Product Detail
                </th>

                <th>
                  Price ({{ $defCurrency->currency->code }})
                </th>

                <th>
                  Categories & More
                </th>

                

                <th>
                  Status
                </th>
                <th>
                  Add / Update on
                </th>

                <th>
                  Actions
                </th>
              </thead>
          </table>
      </div>
</div>

<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="delete-icon"></div>
      </div>
      <div class="modal-body text-center">
        <h4 class="modal-heading">Are You Sure ?</h4>
        <p>Do you really want to delete these top menus? This process cannot be undone.</p>
      </div>
      <div class="modal-footer">
       <form id="bulk_delete_form" method="post" action="{{ route('seller.pro.bulk.delete') }}">
          @csrf
          @method('DELETE')
          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Yes</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@section('custom-script')
<script>
  $(function () {
      "use strict";
      var table = $('#productTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("my.products.index") }}',
          columns: [
              
              {data : 'checkbox', name : 'checkbox',searchable : false,orderable : false},
              {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable : false},
              {data : 'image', name : 'image',searchable : false},
              {data : 'prodetail', name : 'prodetail'},
              {data : 'price', name : 'price'},
              {data : 'catdtl', name : 'catdtl'},
              {data : 'status', name : 'status'},
              {data : 'history', name : 'history'},
              {data : 'action', name : 'action'}
          ],
          dom : 'lBfrtip',
          buttons : [
            'csv','excel','pdf','print','colvis'
          ],
          order : [[0,'DESC']]
      });

      $('#productTable').on('click', '.ptl', function (e) { 

        var id = $(this).data('proid');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type : 'POST',
          data : {productid : $(this).data('proid') },
          datatype : 'html',
          url  : '{{ route('add.price.product') }}',
          success : function(response){
              $('#priceDetail'+id).modal('show');
              $('#pricecontent'+id).html('');
              $('#pricecontent'+id).html(response.body);
          }
      });

    });
      
  });
</script>
@endsection
