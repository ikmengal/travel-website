                if ($row->image && file_exists(public_path('uploads/testimonials/' . $row->image))) {
                    return '<img src="' . asset('uploads/testimonials/' . $row->image) . '"
                                width="60"
                                height="60"
                                class="rounded">';
                }
                return '<span class="badge bg-label-secondary">No Image</span>';
