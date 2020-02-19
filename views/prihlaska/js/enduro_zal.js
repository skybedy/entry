$(function(){
   //Backbone.emulateHTTP = true;
   //Backbone.emulateJSON = true;



    $('body').on('change','select',function(){
        $(this).css('color','#333333');
    });


    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
            } else {
            o[this.name] = this.value || '';
            }
        });
        return o;
    };
    

    Handlebars.registerHelper('years', function(rok_narozeni) {
        var str = '';
        var d = new Date();
        var last_year = d.getFullYear()-1;
        var first_year = last_year-90;
        for(var i = first_year;i<=last_year;i++){
            str += '<option values="'+i+'"';
            if(i == rok_narozeni){
            str = str + ' selected="selected"';
            }
            str += '>'+i+'</option>';
        }
        return str;
    });
    
    
    Handlebars.registerHelper('selected', function(option, value){
        if (Number(option) === Number(value)) {
            return ' selected';
        } else {
            return '';
        }
    });

    Handlebars.registerHelper('Checked', function(etapa,value){
        if(typeof etapa != 'undefined'){
            if(etapa.length == 1){
                if(etapa == value){
                    return ' checked';
                }
            }
            else{
                 for(var i=1;i<=etapa.length;i++){
                    if(etapa[i-1] == value){
                        return ' checked';
                    }
                 }
            }

        }

    });


    Handlebars.registerHelper('selectedtest', function(option, value){
        console.log(option);
        console.log(value);
        if (Number(option) === Number(value)) {
            return ' selected';
        } else {
            return '';
        }
    });

    Handlebars.registerHelper('SelectedString', function(option, value){
        if (option === value) {
            return ' selected';
        } else {
            return '';
        }
    });



    Handlebars.registerHelper('NazevPodzavodu', function(poradi_podzavodu){
        var seznam_kategorii = JSON.parse(sessionStorage.category_list);
        return seznam_kategorii[poradi_podzavodu-1].nazev_podzavodu;
    });
    
    Handlebars.registerHelper('NazevKategorie', function(poradi_podzavodu,id_kategorie){
	var seznam_kategorii = JSON.parse(sessionStorage.category_list);
	for(i=0;i<seznam_kategorii.length;i++){
	    for(k=0;k<seznam_kategorii[i].kategorie.length;k++){
		if(seznam_kategorii[i].kategorie[k].id_kategorie == id_kategorie){
		    return seznam_kategorii[i].kategorie[k].nazev_kategorie;
		}
	    }
	}
    });
    
    Handlebars.registerHelper('NazevMotocyklu', function(id_motocyklu){
        var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
        var znacky_motocyklu = enduro_server_data.znacky_motocyklu;
        var x = _.findWhere(znacky_motocyklu, {id_motocyklu: id_motocyklu});
        return x.nazev_motocyklu;

    });


    Handlebars.registerHelper('Category', function(option, value, id_kategorie){
        var str = '';
        var length = option[value-1].kategorie.length;
        for(var i=1;i<=length;i++){
            str = str + '<option value="'+option[value-1].kategorie[i-1].id_kategorie+'" ';
            if(id_kategorie == option[value-1].kategorie[i-1].id_kategorie){
                str = str + ' selected="selected"';
            }
            str = str + '>'+option[value-1].kategorie[i-1].nazev_kategorie+'</option>';
        }
        return str;
    });

    Handlebars.registerHelper('NazevTymu', function(id_tymu){
        var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
        var tymy = enduro_server_data.tymy;
        var x = _.findWhere(tymy, {id_tymu: id_tymu});
        return x.nazev_tymu;
    });

    Handlebars.registerHelper('NazevPojistovny', function(kod_pojistovny){
        var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
        var zdravotni_pojistovny = enduro_server_data.zdravotni_pojistovny;
        var x = _.findWhere(zdravotni_pojistovny, {kod_pojistovny: kod_pojistovny});
        return x.nazev_pojistovny;
    });

    Handlebars.registerHelper('NazevPohlavi', function(kod_pohlavi){
        var str = 'Muž';
        if(kod_pohlavi == 'Z'){
            str = 'Žena';
        }
        return str;
    });

    Handlebars.registerHelper('Nazev2t4t', function(id_2t4t){
        var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
        var seznam_2t4t = enduro_server_data.seznam_2t4t;
        var x = _.findWhere(seznam_2t4t, {id_2t4t: id_2t4t});
        return x.nazev_2t4t;
    });

    Handlebars.registerHelper('NazevLicence', function(id_typu_licence){
        var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
        var typy_licence = enduro_server_data.typy_licence;
        var x = _.findWhere(typy_licence, {id_typu_licence: id_typu_licence});
        return x.nazev_licence;
    });

    Handlebars.registerHelper('NepovinnaPolozka', function(nazev,value){
        var str = '';
        if(value != ''){
            str = str + '<tr><td>'+nazev+'</td><td>'+value+'</td></tr>';
        }
        return str;

    });
    var Kalendar = Backbone.Model.extend({
        days_of_month : function(){
            var days = [];
            for(var i = 1;i<=31;i++){
                days.push(i);
            }
            return days;
            }(),

        months_of_year: function(){
            var months = [];
            for(var i = 1;i<=12;i++){
                months.push(i);
            }
            return months;
            }()
	});
    
    CategoryList = Backbone.Collection.extend({
	    url: '/prihlaska/vyber-kategorii'
    });
    
    
    
    
    
    EnduroFormRepair = Backbone.View.extend({
        el: "#prihlasovaci_formular_enduro_wrapper",
        template : Handlebars.compile( $("#enduro_form").html()),
        events: {
            "change #poradi_podzavodu": function(ev){
                // nemůže se použít Jquery this, protože to se váže k Backbone 'el'
                //tady bereme pořadí podzávodu ze selectu
                var poradi_podzavodu = $(ev.currentTarget).val();
                this.render(poradi_podzavodu);
            },

            "click #opravit_udaje": function(ev){
                ev.preventDefault();
                //tady už musíme pořadí podzávodu vzít ze session, protože select není k dispozici
                var racer_details = JSON.parse(sessionStorage.racer_details)
                var poradi_podzavodu = racer_details.poradi_podzavodu;
                this.render(poradi_podzavodu);
            }
	},

        render: function(poradi_podzavodu){
            var that = this;
            var kalendar = new Kalendar();
            var category_list = JSON.parse(sessionStorage.category_list);
            if(typeof sessionStorage.racer_details !== 'undefined'){
                var racer_details = JSON.parse(sessionStorage.racer_details);
            }
            var enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);

            that.$el.html(that.template({enduro_server_data:enduro_server_data,category_list:category_list,racer_details:racer_details,kalendar:kalendar,poradi_podzavodu:poradi_podzavodu}));
        }
    });



    var Enduroserverdata = Backbone.Model.extend({
        url: 'prihlaska/server-data-enduro'
    });


    EnduroForm = Backbone.View.extend({
        el: "#prihlasovaci_formular_enduro_wrapper",
        template : Handlebars.compile( $("#enduro_form").html()),
        events: {

            "change #poradi_podzavodu_first": function(ev){
                // nemůže se použít Jquery this, protože to se váže k Backbone 'el'
                var poradi_podzavodu = $(ev.currentTarget).val();
                //alert(poradi_podzavodu);
                this.render(poradi_podzavodu);
            },
	    
	    
	    "submit #overeni_udaju_enduro": function(ev){
            ev.preventDefault();
		    var verification_data = $(ev.currentTarget).serializeObject();
            that = this;
            $.get('./prihlaska/overeni-udaju-enduro',verification_data,function(xhr){
                if(xhr.length > 0){
                    that.render(xhr);
                }
                else{
                    var template = '<div>Kombinace startoního čísla a e-mailu je neplatná</div>';
                    that.$el.html(template);
                }
            });
	    }


        },

        render: function(ido){
            var poradi_podzavodu = 1; //výchozí hodnota pro první zobrazení formuláře
            var that = this;
            var category_list_server = new CategoryList();

            category_list_server.fetch({
               //data:{poradi_podzavodu:poradi_podzavodu}, neptřebné, nechávám pro povědomí
               success:function(category_list_server){
                var enduroserverdata = new Enduroserverdata();
                enduroserverdata.fetch({
                data:{ido:ido},
                success: function(enduro_server_data){

                    sessionStorage.racer_details =JSON.stringify(enduro_server_data.toJSON().racer_data[0]);
                    sessionStorage.category_list = JSON.stringify(category_list_server);
                    sessionStorage.enduro_server_data = JSON.stringify(enduro_server_data);
                    enduro_server_data = JSON.parse(sessionStorage.enduro_server_data);
                    var racer_details = '';
                    if(typeof sessionStorage.racer_details !== 'undefined'){
                        var racer_details = JSON.parse(sessionStorage.racer_details);
                    }
                    that.$el.html(that.template({enduro_server_data:enduro_server_data,category_list:category_list_server.toJSON(),racer_details:racer_details,kalendar:kalendar,poradi_podzavodu:poradi_podzavodu}));

                },
                    error: function(resp){
                        console.log(resp);
                    }

                })
                }
               })
            }
    });
    
    
    
    //kontrolní tabulka
    EnduroControlTable = Backbone.View.extend({
        el: "#prihlasovaci_formular_enduro_wrapper",
        template : Handlebars.compile( $("#enduro_control_table").html()),
        events: {
            "submit #prihlasovaci_formular_enduro": "racerDetails"
        },
        racerDetails: function(ev){
            ev.preventDefault();
            var racer_data = $(ev.currentTarget).serializeObject();
            sessionStorage.racer_details = JSON.stringify(racer_data);
            var racer_details = JSON.parse(sessionStorage.racer_details);
            this.render(racer_details)
        },
        render: function(racer_details){
            this.$el.html(this.template({racer_details:racer_details}));
        }
    });
    
    




    var Prihlaska = Backbone.Model.extend({
        url: '/prihlaska/ulozeni-prihlasky-enduro'
    });


    var OdeslaniPrihlasky = Backbone.View.extend({
        el: "#prihlasovaci_formular_enduro_wrapper",
        template : Handlebars.compile( $("#uspesne_prihlaseni").html()),
        events: {
            "click #odeslat_prihlasku": "neco"
        },





        neco: function(ev){
            ev.preventDefault();
            var racer_data = JSON.parse(sessionStorage.racer_details);
            //console.log(racer_data);
            $.get('./prihlaska/ulozeni-prihlasky-enduro',racer_data,function(xhr){
                //alert(xhr);
                console.log(xhr);
            });


        },

        render: function(){
            this.$el.html(this.template({hlaska:'ahoj'}));

        }







    });

    
    
    
    




    var kalendar = new Kalendar();
    var enduro_form = new EnduroForm();
    var enduro_form_repair = new EnduroFormRepair();
    var enduro_control_table = new EnduroControlTable();
    var odeslani_prihlasky = new OdeslaniPrihlasky();
    
    
    
    
    
    
    
    });
    
    

    
    