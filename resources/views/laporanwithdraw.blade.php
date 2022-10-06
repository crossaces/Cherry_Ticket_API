 <table class="table table-striped">    
        <thead>       
            <tr>               
                <th  style="text-align: center;">Account Name</th>  
                <th  style="text-align: center;">Date Withdraw</th>                
                <th  style="text-align: center;">Total Withdraw</th>  
                <th  style="text-align: center;">Gained Withdraw</th>
                <th  style="text-align: center;">Method Payment</th>
                <th  style="text-align: center;">Account Number</th>                                   
            </tr>
        </thead>
        <tbody>     
         @foreach ($data as $d)   
            <tr>
                <td style="vertical-align : center;text-align:center;" >
                    {{$d->NAMA_TUJUAN}} 
                </td>  
                <td style="vertical-align : center;text-align:center;" >
                   {{$d->TGL_WITHDRAW}}
                </td>   
                <td style="vertical-align : center;text-align:center;" >
                   {{$d->TOTAL_WITHDRAW}}
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

