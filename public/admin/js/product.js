let url = 'https://aisportsoracle.com/admin/';

$('.country_select').change(function() {
  // Get the selected value
  var selectedValue = $(this).val();

      $('.display_none_div').hide();
      $('.remove_name_select').removeAttr('name');
      $(`.LigaSelect${selectedValue}`).show()
      $(`.liga_select${selectedValue}`).attr('name', 'liga_id')

        const formData = new FormData;
        formData.append("country_id", selectedValue);
       $.ajax({
        headers: {
          "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
        },
        url: url+'get_commands',
        method: "POST",
        data: formData, // Use the FormData object
        processData: false, // Prevent jQuery from processing data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
          $('.command_home').html(' ');
          $('.command_guest').html(' ');
          $.each(response.data, function (index, item) {
            var option = $('<option>', {
              value: item.id,
              text: item.name_one,
            });
            var option_guest = $('<option>', {
              value: item.id,
              text: item.name_one,
            });
            $('.command_home').append(option);
            $('.command_guest').append(option_guest);
          });
        },
        error: function (xhr, status, error) {
          // Handle errors here
          $(".submit_button").show();
          if (xhr.responseJSON && xhr.responseJSON.message) {
            alert(xhr.responseJSON.message);
          }
        },
      });

});

$('.remove_name_select').change(function() {
  // Get the selected value
  var selectedValue = $(this).val();



  const formData = new FormData;
  formData.append("liga_id", selectedValue);
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
    },
    url: url+'get_commands',
    method: "POST",
    data: formData, // Use the FormData object
    processData: false, // Prevent jQuery from processing data
    contentType: false, // Prevent jQuery from setting content type
    success: function (response) {

      $('.command_home').html(' ');
      $('.command_guest').html(' ');
      $.each(response.data, function (index, item) {
        var option = $('<option>', {
          value: item.id,
          text: item.name_one,
        });
        var option_guest = $('<option>', {
          value: item.id,
          text: item.name_one,
        });
        $('.command_home').append(option);
        $('.command_guest').append(option_guest);
      });
    },
    error: function (xhr, status, error) {
      // Handle errors here
      $(".submit_button").show();
      if (xhr.responseJSON && xhr.responseJSON.message) {
        alert(xhr.responseJSON.message);
      }
    },
  });

});





const option_one_array = [
    "Исход матча",
    "Исход матча (Двойной шанс)",
    "Тотал голов",
    "Фора (Гандикап)",
    "Забьют - не забьют",
    "Индивидуальный тотал голов",
    "Точный счет",
    "Исход и тотал голов",
    "Исход и обе забьют",
    "Исход 1-го тайма",
    "Тотал голов в 1-м тайме",
    "Угловые: Исходы",
    "Тотал угловых",
    "Индивидуальный тотал угловых",
    "Желтые карты: Исход",
    "Тотал желтых карт",
    "Индивидуальный тотал желтых карт",
    ];
const option_two_array = ["Минимальный", "Низкий", "Средний" , "Высокий" ,"Экстремальный"];
const formDataArray = [];
let i = 0;
let bool = true;
$(document).ready(function () {
  $("#add-inputs").click(function () {
    i++;
    const container = $(`
            <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${i}" >
                    <div style="display: flex; justify-content: space-between">
                    <label>Событие</label>
                    <label>Риск </label>
                 
                </div>
                <div style="display: flex; justify-content: space-between">
                
                          <select style="color: #e2e8f0; width: 30%" name="data[${i}][sobitie]" class="form-control" id="exampleSelectGender">
                                                               
                                                                </select>
                                                                
                     <select style="color: #e2e8f0; width: 30%" name="data[${i}][risk]" class="form-control" id="exampleSelectGender">
                                                             
                                                                </select>
         
                
                </div>
                <br>
                <div style="display: flex; justify-content: space-between">
                    <label>Название</label>
                    <label>КФ </label>
                        <label for="exampleSelectGender">Лучшая ставка</label>
                </div>
                <div style="display: flex; justify-content: space-between">
                    <input required style="width: 30%" name="data[${i}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название" >
                    <input required style="-webkit-appearance: none; width: 30%" name="data[${i}][price]" type="text" class="form-control data" id="exampleInputName1" placeholder="КФ">
                    <input name="data[${i}][id]" type="hidden" value="${i}" class="form-control data" id="exampleInputName1" placeholder="КФ">
                    <div class="form-group" bis_skin_checked="1">
                      
                            <select style="color: #e2e8f0" name="data[${i}][super]" class="form-control" id="exampleSelectGender">
                                                                <option value="1">Нет</option>
                                                                  <option value="0">Да</option>
                                                                </select>
                        </div>
                </div>
                <div id="new_inputs${i}">
                
                    </div>
                <br>
<!--                   <button data_id="${i}" type="button" class="btn btn-inverse-light btn-fw addsub${i}" >Добавить поля</button>-->
                <br>
                <br>
                <div class="tinymce-editor-container">
                    <textarea id="tinymce_${i}" name="data[${i}][description]" class="tinymce-editor"></textarea>
                </div>
            </div>  <br><br> `);

    //////// Stexic dzer chtakl

    $("#input-container").append(container);

    const selectElementOne = $('.delete_inputs_div').find('select[name="data[' + i + '][sobitie]"]');
    const selectElementTwo = $('.delete_inputs_div').find('select[name="data[' + i + '][risk]"]');

    function populateSelect(selectElement, optionArray) {
      selectElement.empty(); // Очищаем текущие option элементы в select
      optionArray.forEach(function (optionText, index) {
        const option = $('<option></option>');
        option.val(optionText); // Устанавливаем значение равное индексу в массиве
        option.text(optionText); // Устанавливаем текст option
        selectElement.append(option); // Добавляем option в select
      });
    }

    // Вызываем функцию для заполнения select элементов данными из массивов
    populateSelect(selectElementOne, option_one_array);
    populateSelect(selectElementTwo, option_two_array);

    tinymce.init({
      height: "400px",
      selector: `#tinymce_${i}`,
      plugins: "link image lists colorpicker",
      toolbar:  "undo redo | styleselect | bold italic | forecolor | link image | bullist numlist",
    });




      $(`.addsub${i}`).on("click", addSubHandler);







  });

  $("form").submit(function (event) {
    event.preventDefault();

    $(".delete_inputs_div").each(function () {
      const startTime = $(this).find('[name^="data["][name$="[start_time]"]').val();

      const price = $(this).find('[name^="data["][name$="[price]"]').val();

      const id = $(this).find('[name^="data["][name$="[id]"]').val();

      const supers = $(this).find('[name^="data["][name$="[super]"]').val();

      const sobitie = $(this).find('select[name^="data["][name$="[sobitie]"]').val();
      const risk = $(this).find('select[name^="data["][name$="[risk]"]').val();


      const description = JSON.stringify(
        tinymce.get(`tinymce_${$(this).attr("data_id")}`).getContent()
      );


      formDataArray.push({
        start_time: startTime,
        price: price,
        description: description,
        id: id,
        super: supers,
        sobitie: sobitie,
        risk: risk
      });
    });
  });
});
//////////       save this code
// $(document).ready(function() {
//     let i = 0;
//
//     $('#add-inputs').click(function() {
//         i++;
//         $('#input-container').append(
//             `<div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${i}" >
//                         <div style="display: flex; justify-content: space-between">
//                             <label>Название</label>
//                             <label>КФ   <span style="color: red; cursor: pointer;" class="x_button_input">x</span></label>
//                         </div>
//                         <div style="display: flex; justify-content: space-between">
//                             <input style="width: 30%" name="data[${i}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название" required>
//                             <input style="-webkit-appearance: none; width: 30%" name="data[${i}][price]" type="number" class="form-control data" id="exampleInputName1" placeholder="КФ" required>
//                         </div>
//                         <br>
//                         <div class="quill-editor-container">
//                             <div style="height: 300px" id="editor_${i}" class="quill-editor"></div>
//                         </div>
//                     </div>  <br><br>`);
//         const quill = new Quill(`#editor_${i}`, {
//             theme: 'snow',
//             sanitize: false, // Disable sanitization
//
//             modules: {
//                 clipboard: {
//                     matchVisual: false // Retain styles from copied content
//                 },
//                 toolbar: [
//
//                     ['bold', 'italic', 'underline', 'strike'],        // usual suspects
//                     ['link', 'blockquote', 'code-block'],
//                     [{ 'list': 'ordered'}, { 'list': 'bullet' }],
//                     [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
//                     [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
//                     [{ 'direction': 'rtl' }],                         // text direction
//
//                     [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
//                     [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
//
//                     [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
//                     [{ 'align': [] }],
//
//                     ['clean']                                         // remove formatting button
//                 ],
//             }
//
//         });
//
//         $('.x_button_input').on('click', function () {
//             $(this).closest('.delete_inputs_div').remove();
//         });
//     });
//
//     $('form').submit(function() {
//         // Retrieve Quill editor content and append it to data array
//         $('.quill-editor').each(function(index) {
//             const content = $(this).find('.ql-editor').html();
//
//             const hiddenInput = `<input type="hidden" name="data[${i}][editor_content]" value="${content}">`;
//             $(this).append(hiddenInput);
//         });
//     });
// });

$(document).ready(function () {
  $("form").submit(function (event) {
    event.preventDefault(); // Prevent the default form submission

    const form = $(this)[0]; // Get the actual form element
    const formData = new FormData(form); // Create a FormData object

    formDataArray.forEach((value, index) => {
      formData.append(`datas[${index}]`, JSON.stringify(value));
    });

    formDataArray.length = 0;
    // formData.append(formDataArray)
    $(".submit_button").hide();

    // Send the form data using AJAX
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
      },
      url: $(this).attr("action"),
      method: "POST",
      data: formData, // Use the FormData object
      processData: false, // Prevent jQuery from processing data
      contentType: false, // Prevent jQuery from setting content type
      success: function (response) {
        alert("Прогноз успешно добавлен");
        window.location.reload();
      },
      error: function (xhr, status, error) {
        // Handle errors here
        $(".submit_button").show();
        if (xhr.responseJSON && xhr.responseJSON.message) {
          alert(xhr.responseJSON.message);
        }
      },
    });
  });
});


function addSubHandler() {
  let data_id = $(this).attr("data_id");
  let new_container = $(`
      <br>
      <div class="form-group delete_inputs_div" bis_skin_checked="1" data_id="${data_id}" >
        <div style="display: flex; justify-content: space-between">
          <label>Название</label>
          <label>КФ</label>
        </div>
        <div style="display: flex; justify-content: space-between">
          <input style="width: 30%" name="data[${data_id}][start_time]" type="text" class="form-control data" id="exampleInputName1" placeholder="Название">
          <input style="-webkit-appearance: none; width: 30%" name="data[${data_id}][price]" type="text" class="form-control data" id="exampleInputName1" placeholder="КФ">
          <input  name="data[${data_id}][id]" value="${data_id}" type="hidden" class="form-control data" id="exampleInputName1" placeholder="КФ">
        </div>
      </div>
    `);

  $(`#new_inputs${data_id}`).append(new_container);
}