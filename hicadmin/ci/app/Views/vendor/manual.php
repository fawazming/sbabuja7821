</div>

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <?php if ($locked): ?>
                        <a class="btn btn-secondary" href="#!" role="button">Disabled || Synchronize Manual Reg</a>
                    <?php else: ?>
                        <a class="btn btn-primary" href="<?=base_url('sync/'.$sheet)?>" role="button">Synchronize Manual Reg</a>
                    <?php endif; ?>
                        </div>
                        <br>
                        <a href="<?=($link) ?>"><?=($link) ?></a>
                    </div>
                    <div class="row">
                        <div class="col text-center">
                            <div class="easypie" data-percent="100" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($reg) ?></span></div>
                            <h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Current Reg. (&#x20a6;<?=($reg*6000)?>)</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="box-title">Manual Delegates</h5>
                    <div class="flexbox mb-4">
                        <div class="flexbox"><label class="mb-0 mr-2">Type:</label><select class="selectpicker form-control show-tick" id="type-filter" title="Please select" data-width="150px">
                                <option value="">All</option>
                            </select></div>
                        <div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered w-100" id="dt-filter">
                            <thead class="thead-light">
                                <tr>
                                    <th>Timestamp</th>
                                    <th>Surname</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sex</th>
                                    <th>Category</th>
                                    <th>Zone</th>
                                    <th>Org</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dels as $key => $delegate): ?>
                                <tr>
                                    <td><?=$delegate->Timestamp?></td>
                                    <td><a href="javascript:;"><?=$delegate->lname?></a></td>
                                    <td><?=$delegate->fname?></td>
                                    <td><?=$delegate->{'phone '}?></td>
                                    <!-- <td><span class="badge badge-success badge-pill">Shipped</span></td> -->
                                    <td><?=$delegate->gender?></td>
                                    <td><?=$delegate->category?></td>
                                    <td><?=$delegate->lb?></td>
                                    <td><?=$delegate->org?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <script src="<?= base_url('assets/admin/vendors/DataTables/datatables.min.js') ?>"></script>
        </div>
    </div>
</div>
</div>

</div>
<!-- END: Page content-->

<!-- BEGIN: Page backdrops-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div><!-- END: Page backdrops-->

<script>

    $(function() {
        // Ajax sourced data
        $('#dt-ajax-data').DataTable({
            ajax: 'assets/demo/data/datatable-data.json',
            responsive: true,
        });
        // Filter & custom search field
        $(function() {
            var table = $('#dt-filter').DataTable({
                responsive: true,
                "sDom": 'Brtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'csv', 'print'
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    orderable: false
                }]
            });
            $('#key-search').on('keyup', function() {
                table.search(this.value).draw();
            });
            $('#type-filter').on('change', function() {
                table.column(3).search($(this).val()).draw();
            });
        });
    });
</script>
