<?php
    include_once "layout/header.php";

    use Controller\BookController;

    $output = new BookController();
    $db_data =  $output->showBooks();
    
    $limit = 3;
    $numbers = $output->paginate($db_data, $limit );
    $result = $output->fetchResult();
    $page_nr = count($numbers);
    
     $current_page = isset($_GET['page']) && $_GET['page'] && is_numeric( $_GET['page']) ?  $_GET['page'] : 1;
    
     $curent_row = ($current_page > 1) ? (($current_page -1) * $limit)+1 : 1;
?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 col-lg-8 p-2 shadow-lg p-3 mb-5 bg-body rounded">

            <div class="p-3">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Pages Nr</th>
                        <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            foreach ($result as $results) {
                            
                                echo "<tr>";
                                echo "<td>".$curent_row."</td>";
                                    echo "<td>".$results['name']."</td>";
                                    echo "<td>".$results['gender']."</td>";
                                    echo "<td>".$results['pages_number']."</td>";

                                if ($results['price'] == 0.00) {
                                    echo '<td><span class="badge bg-success p-2">For Free</span></td>';
                                }else{
                                    echo "<td>".$results['price'].' Ron </td>';
                                }
                                echo "</tr>";
                                $curent_row++;
                            }
                        ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination d-flex justify-content-center">
                        <li class="page-item <?php echo ($current_page == 1)? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo ($current_page > 1)? $current_page - 1 : 1; ?>">Previous</a>
                        </li>

                            <?php 
                            
                                foreach ($numbers as $numb ) {
                                    $active_class = (isset($_GET["page"]) && $_GET["page"] == $numb) ?  "active": "";

                                    echo '<li class="page-item '.$active_class.'">
                                            <a class="page-link active" href="?page='.$numb.'">'.$numb.'</a>
                                        </li>';
                                }
                            ?>     <!--     $_GET["page"] == $numb   because returns last value from loop          -->

                        <li class="page-item <?php echo ($current_page == $numb)? 'disabled' : ''; ?>"> 
                            <a class="page-link" href="?page=<?php echo ($current_page < $numb)? $current_page+1 : $page_nr; ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
    include_once "layout/footer.php";
?>