<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="mt-3">
        <div class="w-full">
            {{-- <div class="grid max-w-xs grid-cols-3 gap-1 p-1 mx-auto my-2 bg-gray-100 rounded-lg" role="group">
                <button type="button" class="text-gray-900 hover:bg-gray-200 px-5 py-1.5 text-xs font-medium rounded-lg">
                    Entrada
                </button>
                <button type="button" class="text-white bg-gray-900 px-5 py-1.5 text-xs font-medium rounded-lg">
                    En proceso
                </button>
                <button type="button" class="text-gray-900 hover:bg-gray-200 px-5 py-1.5 text-xs font-medium rounded-lg">
                    Salida
                </button>
            </div> --}}
            <div class="grid grid-cols-3 gap-8 mt-3">
                <div class="overflow-y-auto max-h-[500px] min-h-[500px] border-2 @if (sizeof($tickets) == 0) bg-white @endif">
                    @if (sizeof($tickets) > 0)
                        @foreach ($tickets as $ticket)
                            <a href="javascript:void(0);" onclick="selectTicket({{ $ticket->id }})">
                                @if ($ticketId == $ticket->id)
                                    <div class="bg-blue-600 text-slate-200 p-6 rounded mb-3 cursor-pointer">
                                @else
                                    <div class="bg-white p-6 rounded mt-3 cursor-pointer">
                                @endif
                                    <p>#{{ $ticket->id }}</p>
                                    <h1>{{ $ticket->phone }}</h1>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="nothing_to_show text-center mt-[240px]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 mx-auto inline"><title>whatsapp</title><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z" /></svg>
                            <p class="italic text-lg text-gray-400 inline">
                                No hay tickets actualmente.
                            </p>
                        </div>
                    @endif
                </div>
                <div class="max-h-[500px] border-2">
                    @if ($messages != null)
                        <div class="bg-white min-h-[435px] max-h-[435px] overflow-y-auto p-1" id="bodyMessages">
                            <?php $i = 0; ?>
                            @foreach ($messages as $msg)
                                <div class="clearfix">
                                    @if ($msg->name == 'venpide')
                                        <div class="bg-green-300 w-[90%] mx-4 my-2 p-3 rounded-lg @if($i > 0) clearfix @endif">
                                            <p class="mb-3">{!! $msg->message !!}</p>
                                            <p class="text-xs italic float-right -mt-2">{{ $msg->created_at }}</p>
                                        </div>
                                    @else
                                        <div class="bg-gray-300 w-[90%] mx-4 my-2 p-3 rounded-lg @if($i > 0) clearfix @endif">   
                                            <p class="mb-3">{!! $msg->message !!}</p>
                                            <p class="text-xs italic float-right -mt-2">{{ $msg->created_at }}</p>
                                        </div>  
                                    @endif
                                </div>
                                <?php $i++; ?>
                            @endforeach
                        </div>
                        <div>
                            <form action="{{ route('send-message') }}" method="POST" class="w-full flex justify-between bg-green-100">
                                <input type="hidden" name="name" value="venpide">
                                <input type="hidden" name="ticketId" value="{{ $ticketId }}">
                                <input type="hidden" name="phone" value="{{ $ticket->phone }}">
                                <input type="hidden" name="isForm" value="1">
                                <textarea name="message" class="flex-grow m-2 py-2 px-4 mr-1 rounded-full border border-gray-300 bg-gray-200 resize-none" rows="1" placeholder="" style="outline: none;"></textarea>
                                <button type="submit" class="m-2" style="outline: none;">
                                    <svg class="svg-inline--fa text-green-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="max-h-[500px] overflow-y-auto border-2">
                    @if ($messages != null)
                        <form action="{{ route('new-order') }}" method="POST" class="p-3 bg-white" id="formAddOrder">
                            @csrf
                            <div class="grid grid-cols-2 gap-4">
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Cliente
                                    </label>
                                    <input type="text" value="@if($order != null){{ $order->customer }}@endif" name="customer" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Tiempo de despacho
                                    </label>
                                    <input type="datetime-local" value="@if($order != null){{ $order->time }}@endif" name="time" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Precio Delivery
                                    </label>
                                    <input type="number" value="@if($order != null){{ $order->price_delivery }}@endif" name="price_delivery" step="0.01" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Precio Pedido
                                    </label>
                                    <input type="number" value="@if($order != null){{ $order->price_order }}@endif" name="price_order" step="0.01" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Latitude
                                    </label>
                                    <input type="text" value="@if($order != null){{ $order->lat }}@endif" name="lat" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                                <div class="mb-1">
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Longitude
                                    </label>
                                    <input type="text" value="@if($order != null){{ $order->lon }}@endif" name="lon" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                                </div>
                            </div>
                            <div class="mt-3">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    Dirección
                                </label>
                                <textarea rows="2" name="address" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">@if($order != null){{ $order->address }}@endif</textarea>
                            </div>
                            <div class="mt-1">
                                <label class="block mb-2 text-sm font-medium text-gray-900">
                                    Pedido
                                </label>
                                <textarea rows="4" name="order" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">@if($order != null){{ $order->order }}@endif</textarea>
                            </div>
                            <input type="hidden" name="ticketId" value="{{ $ticketId }}">
                            <input type="hidden" name="cache" id="inputCache" value="false">
                            <input type="hidden" name="url_return" id="url_return" value="">
                            <div class="mt-5 mb-2 float-right">
                                <button type="button" id="btnGenerateOrder" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                    Crear pedido
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        const bodyMessages  =   document.getElementById('bodyMessages');
        let ticketId        =   0;
        @if($ticketId != 0)
            ticketId = {{ $ticketId }};
            bodyMessages.scrollTop = bodyMessages.scrollHeight - bodyMessages.clientHeight; //scroll siempre en lo último.
        @endif

        function selectTicket(id)
        {
            if(ticketId == id)
                return;
            if(ticketId == 0)
                location.href='{{ url('dashboard') }}?ticketId='+id;
            else {
                const url   =   '{{ url('dashboard') }}?ticketId='+id;
                $("#inputCache").val(true);
                $("#url_return").val(url);
                $("#formAddOrder").submit();
            }
        }
        $("#btnGenerateOrder").click(function() {
            $("#inputCache").val(false);
            $("#url_return").val(null);
            $("#formAddOrder").submit();
        })
    </script>
</x-app-layout>
