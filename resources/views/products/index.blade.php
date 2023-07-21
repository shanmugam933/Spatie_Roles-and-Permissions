@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                @endcan
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <select class="cl_product mt-4" id="ddlproduct">
        <option value="all">All Products </option>
        @foreach ($products as $product)
            <option value="{{$product->name}}">{{$product->name}}</option>
        @endforeach
    </select>
    <div id="productTableWrapper">
        <div class="table-responsive">
        <table id="table11" class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->detail }}</td>
                <td>
                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                        <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                        @can('product-edit')
                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                        @endcan
                        @csrf
                        @method('DELETE')
                        @can('product-delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        @endcan
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    </div>

    {!! $products->links() !!}
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#ddlproduct").on("change", function () {
                var product = $('#ddlproduct').find("option:selected").val();
                SearchData(product)
            });
        });
        function SearchData(product) {
            if (product.toUpperCase() == 'ALL') {
                $('#table11 tbody tr').show();
            } else {
                $('#table11 tbody tr:has(td)').each(function () {
                    var rowproduct = $.trim($(this).find('td:eq(1)').text());

                    if (product.toUpperCase() != 'ALL') {
                        if (rowproduct.toUpperCase() == product.toUpperCase()) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    } else if ($(this).find('td:eq(1)').text() != '' || $(this).find('td:eq(1)').text() != '') {
                        if (product != 'all') {
                            if (rowproduct.toUpperCase() == product.toUpperCase()) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        }
                    }
                });
            }
        }
    </script>
@endsection








