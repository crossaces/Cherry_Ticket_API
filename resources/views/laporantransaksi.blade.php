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
            @foreach ($d->order as $o)        
            <tr>
                <td style="vertical-align : middle;text-align:center;" rowspan="2">
                    {{$d->peserta->NAMA_DEPAN}} {{$d->peserta->NAMA_BELAKANG}}
                </td>                        
            </tr>            
            @endforeach            
        @endforeach     
        </tbody>       
</table>
