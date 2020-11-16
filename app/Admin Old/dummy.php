



















                    















                    
                    <div id="policy" class="tab-pane fade">
                        <h4>Policy</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_5" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_5" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Policy Date</th>
                                        <th>Company Name</th>
                                        <th>Policy Number</th>
                                        <th>Customer Name</th>
                                        <th>Registration Number</th>
                                        <th>Recivable From</th>
                                        <th>Agent Name</th>
                                        <th>Policy Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($policy_result_set){
                                        while($policy_result=$policy_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$policy_result['od_policy_start_date']."</td>";
                                            echo "<td>".$policy_result['company_name']."</td>";
                                            echo "<td>".$policy_result['policy_number']."</td>";
                                            echo "<td>".$policy_result['customer_name']."</td>";
                                            echo "<td>".$policy_result['registration_number']."</td>";
                                            echo "<td>".$policy_result['payment_mode']."</td>";
                                            echo "<td>".$policy_result['od_policy_start_date']."</td>";
                                            if($policy_result['comission_percentage']!=0){
                                                echo "<td>Approved</td>";
                                            }else{
                                                echo "<td>Pending</td>";
                                            }
                                            echo '<td><a href="policy_edit.php?id='.$policy_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                    <div id="company" class="tab-pane fade">
                        <h4>Company</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_6" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_6" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Remark</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($company_result_set){
                                        while($company_result=$company_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$company_result['company_name']."</td>";
                                            echo "<td>".$company_result['remark']."</td>";
                                            echo '<td><a href="company_edit.php?id='.$company_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                    <div id="policyPeriod" class="tab-pane fade">
                        <h4>Policy Period</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_7" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_7" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Policy Period</th>
                                        <th>Remark</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($policy_period_result_set){
                                        while($policy_period_result=$policy_period_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$policy_period_result['policy_period']."</td>";
                                            echo "<td>".$policy_period_result['remark']."</td>";
                                            echo '<td><a href="policy_period_edit.php?id='.$policy_period_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                    <div id="policyType" class="tab-pane fade">
                        <h4>Policy Type</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_8" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_8" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Policy Type</th>
                                        <th>Remark</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($policy_type_result_set){
                                        while($policy_type_result=$policy_type_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$policy_type_result['policy_type']."</td>";
                                            echo "<td>".$policy_type_result['remark']."</td>";
                                            echo '<td><a href="policy_type_edit.php?id='.$policy_type_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                    <div id="product" class="tab-pane fade">
                        <h4>Product</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_9" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_9" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Remark</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($product_result_set){
                                        while($product_result=$product_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$product_result['product']."</td>";
                                            echo "<td>".$product_result['remark']."</td>";
                                            echo '<td><a href="product_edit.php?id='.$product_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>
                    <div id="cheque" class="tab-pane fade">
                        <h4>Cheque</h4>
                        <div class="row filter">
                            <div class="col-sm-6">
                                <div class="search-container">
                                    <form action="" method="POST">
                                        <input id="search_10" type="text" placeholder="Search" name="search">
                                    </form>
                                </div>
                            </div>   
                            
                        </div>
                        <div class="table-scroll">
                            <table id="table_10" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cheque Number</th>
                                        <th>Cheque Date</th>
                                        <th>Bank Name</th>
                                        <th>IFSC Code</th>
                                        <th>Cheque Status</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($cheque_result_set){
                                        while($cheque_result=$cheque_result_set->fetch_assoc()){
                                            echo "<tr>";
                                            echo "<td>".$cheque_result['cheque_number']."</td>";
                                            echo "<td>".$cheque_result['cheque_date']."</td>";
                                            echo "<td>".$cheque_result['bank_name']."</td>";
                                            echo "<td>".$cheque_result['ifsc_code']."</td>";
                                            echo "<td>".$cheque_result['cheque_status']."</td>";
                                            echo '<td><a href="cheque_edit.php?id='.$cheque_result['id'].'"><button>Edit</button></a></td>';
                                            echo "</tr>";
                                        }
                                    }else{
                                        echo "<tr>No records found</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!--<nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>-->
                    </div>








                    $policy_result_set=$user->read_all_policy();
  $company_result_set=$user->read_all_company();
  $policy_period_result_set=$user->read_all_policy_period();
  $policy_type_result_set=$user->read_all_policy_type();
  $product_result_set=$user->read_all_product();
  $cheque_result_set=$user->read_all_cheque();