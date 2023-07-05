<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-8">
                    
                    <div class="row">
                        <div class="col-xl-6 text-dark">

                            <table class="table table-bordered  mb-0">
                                <tbody>
                                     <thead>
                                         <tr><h5>Popular User</h5></tr>
                                         </thead>
                                    <tr>
                                        <td>
                                            <h6>Most Popular Code:</h6>
                                        </td>
                                        <td><?php  echo $mostpopularuser['city_code']; ?></td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h6>Name: </h6>
                                        </td>
                                        <td><?php  echo $mostpopularuser['name']; ?> </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <h6>Gender:</h6>
                                        </td>
                                        <td><?php  echo $mostpopularuser['gender']; ?> </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!--                        <div class="col-xl-6">
                        
                                                    <table class="table table-bordered  mb-0">
                                                        <tbody>
                        
                                                            <tr>
                                                                <td>
                                                                    <h6>Today CMYK:</h6>
                                                                </td>
                                                                <td><?php // echo $todaycmykorder ?> </td>
                                                            </tr>
                        
                                                            <tr>
                                                                <td>
                                                                    <h6>Today CMYK Payment: </h6>
                                                                </td>
                                                                <td><?php // echo $todaypaidcmykorder ?></td>
                                                            </tr>
                        
                                                            <tr>
                                                                <td>
                                                                    <h6>Yesterday CMYK:</h6>
                                                                </td>
                                                                <td><?php // echo $yesterdaycmykorder ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h6>Yesterday Paid CMYK:</h6>
                                                                </td>
                                                                <td><?php // echo $yesterdaypaidcmykorder ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h6>MTD CMYK:</h6>
                                                                </td>
                                                                <td><?php // echo $monthalycmykorder ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h6>MTD CMYK Payment:</h6>
                                                                </td>
                                                                <td><?php // echo $monthalypaidcmykborder ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h6>MTD CC Pending:</h6>
                                                                </td>
                                                                <td><?php // echo $monthalypenddingordercccmyk ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h6>MTD CC Completed:</h6>
                                                                </td>
                                                                <td><?php // echo $monthalyCompletedordercccmyk ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>-->
                    </div>
                </div>

                <!--                <div class="col-xl-4">
                                    <h4 class="text-uppercase text-center">CUSTOMERS SUMMARY</h4>
                                    <div class="row">
                                        <div class="col-xl-12">
                
                                            <table class="table table-bordered  mb-0">
                                                <tbody>
                
                                                    <tr>
                                                        <td>
                                                            <h6>Ordering Partners today:</h6>
                                                        </td>
                                                        <td><?php // echo $todaypartnerorders ?></td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>Ordering Partners This week: </h6>
                                                        </td>
                                                        <td><?php // echo $weekpartnerorders ?></td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>Ordering Partners MTD:</h6>
                                                        </td>
                                                        <td><?php // echo $monthpartnerorders; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>New partners added Today:</h6>
                                                        </td>
                                                        <td><?php // echo $todaypartners; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>New partners added this week:</h6>
                                                        </td>
                                                        <td><?php // echo $weekpartners ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>New partners added MTD:</h6>
                                                        </td>
                                                        <td><?php // echo $monthpartners ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                <!--            <div class="row mt-4 ">
                                <div class="col-xl-12">
                                    <h4 class=" text-uppercase text-center mb-4">Month Till Date summary </h4>
                                    <div class="row">
                                        <div class="col-xl-6">
                                        <h4 class=" text-uppercase text-center ">RGB </h4>
                                            <table class="table table-bordered  mb-0">
                                                <tbody>
                
                                                    <tr>
                                                        <td>
                                                            <h6>Front Office:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyfrontoffice ?> </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>CC: </h6>
                                                        </td>
                                                        <td><?php // echo $monthalycc ?> </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>CC Hold :</h6>
                                                        </td>
                                                        <td><?php // echo $monthalycchold; ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Printing:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyprinting; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Hot Press:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyhotpress ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Post production:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalypostproduction ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Completed:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalycompleted ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Dispached :</h6>
                                                        </td>
                                                        <td><?php // echo $monthalydispached ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                
                                        <div class="col-xl-6">
                                        <h4 class=" text-uppercase text-center ">CMYK </h4>
                                            <table class="table table-bordered  mb-0">
                                                <tbody>
                
                                                <tr>
                                                        <td>
                                                            <h6>Front Office:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyfrontofficecmyk; ?> </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>CC: </h6>
                                                        </td>
                                                        <td><?php // echo $monthalycccmyk; ?> </td>
                                                    </tr>
                
                                                    <tr>
                                                        <td>
                                                            <h6>CC Hold :</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyccholdcmyk; ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Printing:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalyprintingcmyk; ?></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td>
                                                            <h6>Post production:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalypostproductioncmyk ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Completed:</h6>
                                                        </td>
                                                        <td><?php // echo $monthalycompletedcmyk ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h6>Dispatched :</h6>
                                                        </td>
                                                        <td><?php // echo $monthalydispachedcmyk ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
            </div>
        </div>

    </div>