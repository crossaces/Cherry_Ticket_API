 <table class="table table-striped">    
        <thead>       
            <tr>               
                <th  style="text-align: center;">Full Name</th>  
                <th  style="text-align: center;">Transaction Date</th> 
                <th  style="text-align: center;">Total Price</th>  
                <th  style="text-align: center;">Method Payment</th>  
                <th  style="text-align: center;">Status</th>                  
            </tr>
        </thead>
        <tbody>     
         @foreach ($data as $d)   
            <tr>
                <td  rowspan="{{count($d->order)}}" style="vertical-align : center;text-align:center;" >
                    {{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}
                </td>                                       
            </tr>                        
            @foreach ($d->order as $o)                    
            <tr>                
                <td style="vertical-align : left;text-align:left;" >
                    {{$o->tiket->NAMA_TIKET}}
                </td>      
            </tr>        
            @endforeach            
        @endforeach     
        </tbody>       
</table>
