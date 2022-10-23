@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card">
                <div class="card-header d-flex">
                    <h2>{{ __('Frontend/frontend.invoices') }}</h2>
                    <a href="{{ route('invoices.create') }}" class="btn btn-primary ml-auto"><i class="fa fa-plus"></i>
                        {{ __('Frontend/frontend.create_invoice') }}</a>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('Frontend/frontend.customer_name') }}</th>
                                <th>{{ __('Frontend/frontend.invoice_date') }}</th>
                                <th>{{ __('Frontend/frontend.total_due') }}</th>
                                <th>{{ __('Frontend/frontend.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td><a
                                            href="{{ route('invoices.show', $invoice->id) }}">{{ $invoice->customer_name }}</a>
                                    </td>
                                    <td>{{ $invoice->invoice_date }}</td>
                                    <td>{{ $invoice->total_due }}</td>
                                    <td>
                                        <a href="{{ route('invoices.edit', $invoice->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm"
                                            onclick="confirmDestroy({{ $invoice->id }},this)">
                                            <i class="fa fa-trash"></i></a>
                                        {{-- <a href="javascript:void(0)" onclick="if (confirm('{{ __('Frontend/frontend.r_u_sure') }}')) { document.getElementById('delete-{{ $invoice->id }}').submit(); } else { return false; }" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="post" id="delete-{{ $invoice->id }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="float-right">
                                        {!! $invoices->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function confirmDestroy(id, referance) {
            Swal.fire({
                title: '{{ __('Frontend/frontend.r_u_sure') }}',
                text: "{{ __('Frontend/frontend.confirm_delete_text') }}",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('Frontend/frontend.confirm_delete') }}'
                // cancelButtonText: '{{ __('Frontend/frontend.cancel_delete') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    destroy(id, referance);
                }
            })
        }

        function destroy(id, referance) {
            axios.delete('/invoices/' + id)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    referance.closest('tr').remove();
                    showMessage(response.data)
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    showMessage(error.response.data)
                })
        }

        function showMessage(data) {
            Swal.fire({
                icon: data.icon,
                title: data.title,
                text: data.text,
                showConfirmButton: false,
                timer: 1500
            })
        }
    </script>
@endsection
