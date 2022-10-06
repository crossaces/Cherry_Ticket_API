 <table class="table table-striped">    
        <thead>       
            <tr>               
                <th  style="text-align: center;">Event Organizer</th>  
                <th  style="text-align: center;">Account Name</th>  
                <th  style="text-align: center;">Date Withdraw</th>                
                <th  style="text-align: center;">Total Withdraw</th>  
                <th  style="text-align: center;">Income Withdraw</th>
                <th  style="text-align: center;">Method Payment</th>
                <th  style="text-align: center;">Account Number</th> 
                <th  style="text-align: center;">STATUS WITHDRAW</th>                                    
            </tr>
        </thead>
        <tbody>     
         @foreach ($data as $d)   
            <tr>
                <td style="vertical-align : center;text-align:center;" >
                    {{$d->eo->NAMA_EO}} 
                </td> 
                <td style="vertical-align : center;text-align:center;" >
                    {{$d->NAMA_TUJUAN}} 
                </td>  
                <td style="vertical-align : center;text-align:center;" >
                   {{$d->TGL_WITHDRAW}}
                </td>   
                 <td style="vertical-align : center;text-align:center;" >
                   {{$d->JUMLAH_WITHDRAW}}
                </td> 
                <td style="vertical-align : center;text-align:center;" >
                   {{$d->INCOME_ADMIN}}
                </td>    
                 <td style="vertical-align : center;text-align:center;" >
                   {{$d->METHOD_PAYMENT}}
                </td> 
                <td style="vertical-align : center;text-align:center;" >
                   {{$d->NOMOR_TRANSAKSI}}
                </td>   
                 <td style="vertical-align : center;text-align:center;" >
                   {{$d->STATUS_WITHDRAW}}
                </td>                                               
            </tr>                                                                                                                   
                  
        @endforeach     
        </tbody>       
</table>

