import('../styles/style.scss');
import('bootstrap');
const mustache = require('mustache');
const $ = require('jquery');
global.$ = $;

let postsWrapper =  $('.postsWrapper');
let postsPagination = $('.postsPagination');

if (postsWrapper.length) {
    getBlogs();
}

function getBlogs(params = {page: 1}) {
    $.ajax({
        url: '/api/blogs',
        type: 'POST',
        data: params,
        dataType: 'json',
        success: function(response) {
            showBlogs(response.data);
            createPagination(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showModal('Ошибка', jqXHR.responseJSON.message);
        }
    });
}

function createPagination(data) {
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

    postsPagination.html(html);

    $('.selectPage').on('click', function(e) {
        e.preventDefault();
        let page = $(this).attr('page');
        getBlogs({page: page});
    });
}

function showBlogs(data) {
    let html = '';

    if (data.total) {
        Object.values(data.posts).forEach(item => {
            html += mustache.render(templateCard, {
                autor: item.autor,
                text: item.text
            });
        });
    }

    postsWrapper.html(html);
}

let templateCard = '<div class="col">' +
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

$('.ajaxForm').submit(function(e) {
    e.preventDefault();

    let $form = $(this);
    let formData = $form.serialize();

    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: formData,
        dataType: 'json',
        success: function(response) {
            if(response.redirect) {
                window.location.href = response.redirect;
            } else {
                showModal('Сообщение', response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showModal('Ошибка', jqXHR.responseJSON.message);
        }
    });
});

function showModal(title, message) {
    $('#modal .modalTitle').html(title);
    $('#modal .modalText').html(message);
    $('#modal').modal('show');
}