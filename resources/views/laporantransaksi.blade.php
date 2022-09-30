 <table class="table table-striped">    
        <thead>       
            <tr>               
                <th  style="text-align: center;">Full Name</th>  
                <th  style="text-align: center;">Transaction Date</th>                
                <th  style="text-align: center;">Method Payment</th>  
                <th  style="text-align: center;">Status</th>
                <th  style="text-align: center;">Total Price</th>  
                <th  colspan="3" style="text-align: center;">Order</th>                        
            </tr>
        </thead>
        <tbody>     
         @foreach ($data as $d)   
            <tr>
                <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                    {{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}
                </td>  
                <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                   {{$d->TGL_TRANSAKSI}}
                </td>   
                <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                   {{$d->METODE_PEMBAYARAN}}
                </td>    
                 <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                   {{$d->STATUS_TRANSAKSI}}
                </td> 
                <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                   {{$d->TOTAL_HARGA}}
                </td>               
                <td style="vertical-align : left;text-align:left;" >
                   Tiket Type
                </td> 
                 <td style="vertical-align : left;text-align:left;" >
                    Quantity
                </td>                           
            </tr>                                                                                                         
            @foreach ($d->order as $o)    
             <tr>                                         
                <td style="vertical-align : left;text-align:left;" >
                    {{$o->tiket->NAMA_TIKET}}
                </td> 
                 <td style="vertical-align : left;text-align:left;" >
                    {{$o->JUMLAH}}
                </td> 
             </tr>                  
            @endforeach      
                  
        @endforeach     
        </tbody>       
</table>
