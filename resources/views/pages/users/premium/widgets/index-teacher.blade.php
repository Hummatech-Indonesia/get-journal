<div class="card">
    <div class="card-body">
        <form action="" method="post">
            @csrf
            <div class="table-responsive">
                <select name="teacher_id" id="teacher_id">
                    <option value="id">Helo</option>
                </select>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="teacher-list">
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#teacher_id').selectize({
                
            })
        })
    </script>
@endpush