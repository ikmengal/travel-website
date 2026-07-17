$checked = $row->featured ? 'checked' : '';
                    return '
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input changeFeatured"
                            type="checkbox"
                            data-id="' . $row->id . '"
                            ' . $checked . '>
                    </div>';
