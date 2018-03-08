(function ($) {

    var defaults = {
        div: '<div class="dropdown bts_dropdown"></div>',
        button: '<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span></span> <i class="caret"></i></button>',
        ul: '<ul class="dropdown-menu"></ul>',
        li: '<li><label></label></li>',
        buttonText: '-',
        allItemsText: 'All items selected',
        itemsSelectedText: 'items selected'
    };

    $.fn.treeselect = function (options) {
      var $select = $(this),
          settings = $.extend(defaults, options),
          placeholder = $select.data('placeholder'),
          allItemsText = $select.data('all-items-text'),
          itemsSelectedText = $select.data('items-selected-text');

      if (typeof placeholder !== 'undefined') {
        settings.buttonText = placeholder;
      }
      if (typeof allItemsText !== 'undefined') {
        settings.allItemsText = allItemsText;
      }
      if (typeof itemsSelectedText !== 'undefined') {
        settings.itemsSelectedText = itemsSelectedText;
      }

      var $div = $(settings.div);
      var $button = $(settings.button);
      var $ul = $(settings.ul).click(function (e) {
          e.stopPropagation();
      });

      initialize();

      function initialize() {
          $select.after($div);
          $div.append($button);
          $div.append($ul);

          createList();
          updateButtonText();

          $select.remove();
      }

      function createStructure(selector) {
          var options = [];
          $select.children(selector).each(function (i, el) {
              var $el = $(el);
              options.push({
                  value: $el.val(),
                  text: $el.text(),
                  checked: $el.attr('selected') ? true : false,
                  children: createStructure('option[data-parent="' + $el.val() + '"]')
              });
          });

          return options;
      }

      function createListItem(option) {
          var $input = null,
              $li = $(settings.li),
              $label = $li.children('label');
          $label.text(option.text);

          if ($select.attr('multiple')) {
              $input = $('<input type="checkbox" name="' + $select.attr('name').replace('[]','') + '[]" value="' + option.value + '">');
          } else {
              $input = $('<input type="radio" name="' + $select.attr('name') +'" value="' + option.value + '">');
          }

          if (option.checked) {
              $input.attr('checked', 'checked');
          }
          $label.prepend($input);

          $input.change(function () {
              updateButtonText();
          });

          if (option.children.length > 0) {
              $(option.children).each(function (i, child) {
                  var $childUl = $('<ul></ul>').appendTo($li);
                  $childUl.append(createListItem(child));
              });
          }

          return $li;
      }

      function createList() {
          $(createStructure('option:not([data-parent])')).each(function (i, option) {
              var $li = createListItem(option);
              $ul.append($li);
          });
      }

      function updateButtonText() {
          var buttonText = [];

          $div.find('input').each(function (i, el) {
              var $checkbox = $(el);
              if ($checkbox.is(':checked')) {
                  buttonText.push($checkbox.parent().text());
              }
          });

          if (buttonText.length > 0) {
              if (buttonText.length < 4) {
                  $button.children('span').text(buttonText.join(', '));
              } else if ($div.find('input').length == buttonText.length) {
                  $button.children('span').text(settings.allItemsText);
              } else {
                  $button.children('span').text(buttonText.length + ' ' + settings.itemsSelectedText);
              }
          } else {
              $button.children('span').text(settings.buttonText);
          }
        }
    };
}(jQuery));
