(function($) {
    $(document).ready(function() {
        var count = $('#lbk-custom-faq-script').attr('data-count');
        $("#add_new_faq_button").click(function(e) {
            e.preventDefault();

            $("#lbk_list_faqs > tbody:last-child").append(`
                <tr id="faq-${count}">
                    <td class="faqData">
                        <input name="lbk_faq_custom[${count}][question]" value="" placeholder="Question?" style="width:100%">
                    </td>
                    <td class="faqData">
                        <input name="lbk_faq_custom[${count}][answer]" value="" placeholder="Answer" style="width:100%">
                    </td>
                    <td align="center">
                        <a href="#" class="button" id="lbk_delete_faq" data-id="${count}">Delete</a>
                    </td>
                </tr>
            `);

            count++;
        });

        $("#lbk_list_faqs").on('click', '#lbk_delete_faq', function(e) {
            e.preventDefault();

            var action = confirm("Are you sure you want to delete this user?");
            var faq_id = $(this).attr('data-id');
            if (action != false) {
                $("#lbk_list_faqs #faq-" + faq_id).remove();
            }
        });
    });
})(jQuery);