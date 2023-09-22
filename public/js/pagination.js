$(document).ready(function(){
    // Bind a click event handler to all elements with the class "pagination"
    $('.pagination').on('click', function (e) {
        // Prevent the default behavior of the link (to avoid navigating to a new page)
        e.preventDefault();
        $('.pagination').hide()
        // Get the URL from the "href" attribute of the clicked link
        var url = $(this).attr('data_url');
        // Send an AJAX request to the URL
        $.ajax({
            type: 'GET', // You can change this to 'POST' or other HTTP methods if needed
            url: url,
            success: function(response) {

                $.each(response.data.data, function(index, item) {

                    $('.content-bets').append(`
             <div class="bet favorite" bis_skin_checked="1">
            <div class="title" bis_skin_checked="1">
                                    <img src="${item.star_url}" alt="cup.svg">
                                        <div class="title__country-name__wrapper" bis_skin_checked="1">
                    <p style="    text-transform: uppercase;">${item.country_name.name}</p> ${item.liga} - ${item.title}
                </div>
            </div>
            <div class="time-left" bis_skin_checked="1" style="${item.style}"> <img src="../../public/public/images/time-icon.svg" alt=""> ${item.string} <span>   ${item.diforhumans} </span></div>
            <div class="teams" bis_skin_checked="1">
                <div class="team-1" bis_skin_checked="1">
                    <img class="team-1-logo" src="https://aisportsoracle.com/uploads/${item.team_one_logo}" alt="team-1">
                    <div class="team-1-name" style="display: flex; justify-content: center;" bis_skin_checked="1">${item.team_one}</div>
                                        <div class="team-1-name__alternate" style="display: flex; justify-content: center; font-size: 10px; ${item.team_two_two_div}" bis_skin_checked="1">(${item.team_one_two})</div>
                                    </div>
                <div class="team-2" bis_skin_checked="1">
                    <img class="team-2-logo" src="https://aisportsoracle.com/uploads/${item.team_two_logo}" alt="team-1">
                    <div class="team-2-name" style="text-align: center" bis_skin_checked="1">
                        ${item.team_two}
                    </div>
                                        <div class="team-2-name__alternate" style="text-align: center ; font-size:10px; ; ${item.team_two_two_div}" bis_skin_checked="1">
                        (${item.team_two_two})
                    </div>
                    
                </div>
            </div>
            
            <div class="count-wrapper" bis_skin_checked="1" style="${item.analize_div}">
                    

                    <div class="count-all" bis_skin_checked="1">
                        <div class="count-all__title" bis_skin_checked="1">${item.vsego}:</div>
                        <div class="count-all__num" bis_skin_checked="1">${item.get_all_attr_true}/${item.get_all_attr}</div>
                    </div>

    
                    <div class="count-event" bis_skin_checked="1">
                        <div class="count-event__title" bis_skin_checked="1">${item.lucshaya}:</div>
                        <div class="count-event__num" bis_skin_checked="1">${item.get_all_attr_star_true}/${item.get_all_attr_star}</div>
                    </div>
                </div>
                                    

            <a href="${item.single_page}" bis_skin_checked="1"><button type="button" class="main-btn">${item.button_text}</button></a>
        </div>
                    `);
                });

                if (response.next_page_url != null){
                    $('.pagination').show()
                    $('.pagination').attr('data_url', response.next_page_url);
                } else {
                    $('.pagination').hide()
                }
            },
            error: function(error) {
                // Handle any errors that occur during the AJAX request
                console.error(error);
            }
        });
    });
});
