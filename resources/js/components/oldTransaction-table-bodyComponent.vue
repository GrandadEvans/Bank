    //             //         {
    //             //             name: "remarks",
    //             //             render: function (remark, type, row, meta) {
    //             //                 return make_remarks_form(remark, type, row, meta);
    //             //             }
    //             //         },
    //             //         {
    //             //             name: "edit",
    //             //             render: function (data, type, row, meta) {
    //             //                 let out = '',
    //             //                     provider_id = parseInt(row.provider_id);
    //             //
    //             //                 out += `<a href="${data}"><i class="fas fa-edit"></i></a>`;
    //             //                 if (provider_id === 1) {
    //             //                     out += `
    //             //                             <a
    //             //                                 href="${meta.settings.json.provider_add_link}"
    //             //                                 id="edit-transaction-${provider_id}"
    //             //                             >
    //             //                                 <i title="Add Provider" class="fas fa-plus-circle"></i>
    //             //                             </a>
    //             //                     `;
    //             //                 }
    //             //                 out += `
    //             //                     <span
    //             //                         style="margin-left: 0.5rem;"
    //             //                         data-id="${row.transaction_id}"
    //             //                         :id="${row.transaction_id}"
    //             //                         class="edit_transaction_tags"
    //             //                         v-on:click="getTransactionTags"
    //             //                         >
    //             //
    //             //                         <i class="fas fa-tag"
    //             //                             data-id="${row.transaction_id}"
    //             //                            :id="${row.transaction_id}"
    //             //                             v-on:click="getTransactionTags"
    //             //                         ></i>
    //             //                     </span>`;
    //             //                 return out;
    //             //             }
    //             //         }
    //             //     ],
    //             .on('click', '.transaction-description', (el) => transaction_search_from_form(table, el))
    //             .on('click', '.transaction-provider', (el) => transaction_search_from_form(table, el))
    //             .on('click', '.edit_transaction_tags', (el) => this.getTransactionTags(table, el))
    //             .on('blur', '.transaction-remark-inline-input', el => send_updated_remark(table, el));
    //
    //         let transaction_search_passed_in = (table, val) => {
    //             table.
    //             search(val)
    //                 .draw();
    //         }
    //         if (this.search !== '') {
    //             transaction_search_passed_in(table, this.search);
    //         }
    //
    //         $('.dataTables_filter')
    //             .append(`<i class="far fa-times-circle datatables_search_reset"></i>`);
    //
    //         $('.datatables_search_reset')
    //             .on('click', function(el) {
    //                 table
    //                     .search('')
    //                     .draw();
    //         });
    //
    //         let send_updated_remark = el => {
    //             if (el.target.value.length == 0) {
    //                 return;
    //             }
    //
    //             let dataset = el.target.dataset,
    //                 route = dataset.route,
    //                 data = {
    //                     'transaction_id': dataset.transaction_id,
    //                     'remarks': el.target.value,
    //                     '_method': dataset.method,
    //                     '_csrf': dataset.csrf
    //                 };
    //
    //             $.ajax(route,
    //                 {
    //                     type: "POST",
    //                     data: data,
    //                 })
    //                 .done(() => {
    //                     Swal.fire({
    //                         icon: 'success',
    //                         title: 'Remark Updated!',
    //                         text: 'The remark has been updated'
    //                     });
    //                 })
    //                 .fail(() => {
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Woops!',
    //                         text: 'There was an error updating the remark'
    //                     });
    //                 })
    //                 .always(() => {
    //                 })
    //
    //         };
    //
    //         let make_remarks_form = (current, type, row, meta) => {
    //             let csrf_token = meta.settings.json.csrf; // no longer needed
    //             let truncated = textTruncate(current, 30);
    //
    //
    //             let form = `
    //                 <input
    //                     type="text"
    //                     value="${truncated}"
    //                     name="transaction_remark"
    //                     class="transaction-remark-inline-input"
    //                     data-transaction_id="${row.transaction_id}"
    //                     data-method="PUT"
    //                     data-csrf="${csrf_token}"
    //                     data-route="${row.route}"
    //                     />
    //                 <i
    //                     class="far fa-question-circle transaction-remark-help"
    //                     title="${current}"></i>
    //             `;
    //
    //             return form;
    //         }
    //
    //         let transaction_search_from_form = (table, el) => {
    //             table.
    //                 search(el.target.innerHTML)
    //                 .draw();
    //         }
    //         let textTruncate = (str, length=100, ending="...") => {
    //             if (str && str.length > length) {
    //                 return str.substring(0, length - ending.length) + ending;
    //             } else {
    //                 return str;
    //             }
    //         }
    //
    //         $('.tx_selector').change(function() {
    //             vm.countSelectedTransactions();
    //         });
    //     }
    }
</script>
