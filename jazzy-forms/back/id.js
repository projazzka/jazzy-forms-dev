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
            name = base + '_' + idx;
            idx++;
        }
        return name;
    }
    
    this.suggest_title = function(base) {
        var matches = /^(.+) ([0-9]+)$/.exec(base)
        if(matches) {
            var root = matches[1]
            var number = Number(matches[2])
        } else {
            var root = base
            number = 0
        }
        var found;
        do {
            number++;
            if(number == 1) {
                result = root;
            } else {
                result = root + " " + number
            }
        } while(this.column_occupied(result, 'title'))
        return result
    }
    
    this.title_to_name = function(title) {
        title = title.toLowerCase();
        title = title.replace(/ /g, "_");
        return title.replace(/[^a-zA-Z0-9_]/g, "");
    }
}