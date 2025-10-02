(function($) {
    const mustache = require('mustache');

    $.fn.showBlogs = function() {
        let params = {page: 1};

        return this.each(function() {
            let $this = $(this);
            let $content = $('<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3"></div>');
            let $pagination = $('<ul class="pagination justify-content-center"></ul>');

            $this.append($content)
                 .append($('<nav class="mt-5"></nav>').append($pagination));

            getBlogs(params, $content, $pagination);
        });

        function getBlogs(params, $content, $pagination) {
            $.ajax({
                url: '/api/blogs',
                type: 'POST',
                data: params,
                dataType: 'json',
                success: function(response) {
                    showBlogs(response.data, $content);
                    createPagination(response.data, $content, $pagination);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    window.helper.showModal('Ошибка', jqXHR?.responseJSON?.message ?? 'Непредвиденная ошибка');
                }
            });
        }

        function createPagination(data, $content, $pagination) {
            let pages = data.pages;
            let cPage = ""+data.currentPage;
            let pagesLimit = 4;
            let html = '';

            if (pages > 1) {
                html += '<li class="page-item '+ (cPage == 1 && 'disabled') +'"><a class="page-link selectPage" page="'+ (cPage-1) +'" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                let limitLast = 1;

                for (let index = 1; index <= pages; index++) {
                    if (0 == (cPage - pagesLimit) - index) {
                        html += '<li class="page-item"><a class="page-link selectPage" page="1" href="#"><span aria-hidden="true">1</span></a></li>';
                        if (1 !== index && index > 2) {
                            html += '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">...</span></a></li>';
                        } else if (index == 2) {
                            html += '<li class="page-item"><a class="page-link selectPage" page="'+index+'" href="#"><span aria-hidden="true">'+index+'</span></a></li>';
                        }
                    } else if (0 == (cPage + pagesLimit) - index && (cPage + pagesLimit) < pages) {
                    } else if (0 < (cPage - pagesLimit) - index) {
                    } else if (0 > (cPage + pagesLimit) - index) {
                    } else if ( cPage > (index - pagesLimit)) {
                        html += '<li class="page-item '+ (cPage == index && 'active') +'"><a class="page-link selectPage" page="'+index+'" href="#">'+ index +'</a></li>';
                    } else if (cPage == (index - pagesLimit)) {
                        if (index == pages || index == (pages-1)) {
                            html += '<li class="page-item"><a class="page-link selectPage" page="'+index+'" href="#"><span aria-hidden="true">'+index+'</span></a></li>';
                        } else if (index < pages) {
                            html += '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">...</span></a></li>';
                        }
                    }  else if (cPage < (index - pagesLimit) && limitLast) {
                        limitLast = 0;
                        html += '<li class="page-item"><a class="page-link selectPage" page="'+pages+'" href="#"><span aria-hidden="true">'+pages+'</span></a></li>';
                    } 
                }

                html += '<li class="page-item '+ (cPage == pages && 'disabled') +'"><a class="page-link selectPage" page="'+ (+cPage+1) +'" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
            }

            $pagination.html(html);

            $pagination.find('.selectPage').on('click', function(e) {
                e.preventDefault();
                let page = $(this).attr('page');
                getBlogs({page: page}, $content, $pagination);
            });
        }

        function showBlogs(data, $content) {
            let html = '';

            if (data.total) {
                Object.values(data.posts).forEach(item => {
                    html += mustache.render($.fn.showBlogs.templateCard, {
                        autor: item.autor,
                        text: item.text
                    });
                });
            }

            $content.html(html);
        }
    };

    $.fn.showBlogs.templateCard = '<div class="col">' +
                                    '<div class="card shadow-sm">' +
                                        '<svg aria-label="Thumbnail" class="bd-placeholder-img card-img-top" height="225" role="img" width="100%" xmlns="http://www.w3.org/2000/svg">' +
                                            '<title>Placeholder</title>' +
                                            '<rect width="100%" height="100%" fill="#55595c"></rect>' +
                                            '<text x="50%" y="50%" fill="#eceeef" dx="-2em">Thumbnail</text>' +
                                        '</svg>' +
                                        '<div class="card-body">' +
                                            '<p class="card-text">{{text}}</p>' +
                                            '<div class="d-flex justify-content-between align-items-center">' +
                                                '<small class="text-body-secondary">' +
                                                    'Автор: <span class="autor">{{autor}}<span>' +
                                                '</small>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';
})(jQuery);