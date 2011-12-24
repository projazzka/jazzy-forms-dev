function jzzf_id(arr) {
    
    this.column_occupied = function(val, column) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i][column] == val) {
                return true;
            }
        }
        return false;
    }
    
    this.suggest_name = function(title) {
        var base = this.title_to_name(title);
        var name = base;
        var idx = 1;
        while(this.column_occupied(name, 'name')) {
            name = base + '-' + idx;
            idx++;
        }
        return name;
    }
    
    this.suggest_title = function(base) {
        var title = base;
        var idx = 1;
        while(this.column_occupied(title, 'title')) {
            title = base + ' (' + idx + ')';
            idx++;
        }
        return title;
    }
    
    this.title_to_name = function(title) {
        title = title.toLowerCase();
        title = title.replace(/ /, "_");
        return title.replace(/[^a-zA-Z0-9_]/g, "");
    }
}