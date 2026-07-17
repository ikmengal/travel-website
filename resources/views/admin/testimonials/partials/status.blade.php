$checked = $row->status ? 'checked' : '';
                    return '
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input changeStatus"
                            type="checkbox"
                            data-id="' . $row->id . '"
                            ' . $checked . '>
                    </div>';
