function Task(data) {
    this.title = ko.observable(data.name);
    this.isDone = ko.observable(data.id);
}

function TaskListViewModel() {
    // Data
    var self = this;
    self.tasks = ko.observableArray([]);
    self.newTaskText = ko.observable();
    self.incompleteTasks = ko.computed(function() {
        return ko.utils.arrayFilter(self.tasks(), function(task) { return !task.isDone() });
    });

    // Operations
    self.addTask = function() {
        self.tasks.push(new Task({ title: this.newTaskText() }));
        self.newTaskText("");
    };
    self.removeTask = function(task) { self.tasks.remove(task) };

     $.getJSON("/?controller=lab&action=getAll", function(allData) {
         console.log(allData);
        var mappedTasks = $.map(allData.data, function(item) { return new Task(item) });
        self.tasks(mappedTasks);
    });
}

ko.applyBindings(new TaskListViewModel());