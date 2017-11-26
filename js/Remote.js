/*jslint esnext:true,browser:true*/
class Remote {
	constructor() {
		this.commands = this.getCommands(document);
	}
	static init() {
		this.evt = {
			window: {
				load: function () {
					var remote;
					remote = new Remote();
				},
				keypress: function (e) {
					switch (e.code) {
						case "End":
							Command.execute("w");
						break;
						case "Home":
							Command.execute("o");
						break;
						case "VolumeMute": case "F4":
							Command.execute("M");
						break;
						case "Insert":
							Command.execute("s");
						break;
						case "Space":
							Command.execute("p");
						break;
						case "Escape":
							if (e.ctrlKey || e.shift) {
								Command.execute("X");
							} else {
								Command.execute("t");
							}
						break;
						case "S":
							Command.execute("\\\\\\\\");
						break;
						case "M":
							Command.execute(",");
						break;
						case "Backspace":
							Command.execute("T");
						break;
						case "ArrowUp":
							if (e.ctrlKey || e.shift) {
								Command.execute("U");
							} else {
								Command.execute("u");
							}
						break;
						case "ArrowDown":
							if (e.ctrlKey || e.shift) {
								Command.execute("D");
							} else {
								Command.execute("d");
							}
						break;
						case "ArrowLeft":
							if (e.ctrlKey || e.shift) {
								Command.execute("t");
							} else {
								Command.execute("l");
							}
						break;
						case "ArrowRight":
							if (e.ctrlKey || e.shift) {
								Command.execute("n");
							} else {
								Command.execute("r");
							}
						break;
						case "PageUp":
							Command.execute("U");
						break;
						case "PageDown":
							Command.execute("D");
						break;
						case "Enter":
							Command.execute("n");
						break;
					}
					switch (e.key) {
						case "<":
							Command.execute("H");
						break;
						case ">":
							Command.execute("I");
						break;
						case "[":
							Command.execute("[");
						break;
						case "]":
							Command.execute("]");
						break;
						case "=":
							Command.execute("G");
						break;
						case "A":
							Command.execute("x");
						break;
						case "B":
							Command.execute("y");
						break;
						case "C":
							Command.execute("z");
						break;
						case "D":
							Command.execute("A");
						break;
						case "1":
							Command.execute("1");
						break;
						case "2":
							Command.execute("2");
						break;
						case "3":
							Command.execute("3");
						break;
						case "4":
							Command.execute("4");
						break;
						case "5":
							Command.execute("5");
						break;
						case "6":
							Command.execute("6");
						break;
						case "7":
							Command.execute("7");
						break;
						case "8":
							Command.execute("8");
						break;
						case "9":
							Command.execute("9");
						break;
						case "0":
							Command.execute("0");
						break;
					}
				}
			}
		};
		this.addEventListeners(window, this.evt.window);
//		this.addEventListeners(document, this.evt.window);
	}
	static addEventListeners(object, events) {
		var k;
		if (object instanceof Array) {
			return object.forEach((element)=>(this.addEventListeners(element, events)), this), this;
		}
		for (k in events) {
			object.addEventListener(k, events[k]);
		}
		return this;
	}
	getCommands(domain) {
		var result, elements;
		elements = domain.querySelectorAll("[data-command]");
		result = elements.forEach((element) => (new Command(element)));
		return result;
	}

}
Remote.init();
class Command {
	constructor() {
		this.init.apply(this, arguments);
	}
	init(key) {
		if (key instanceof HTMLElement) {
			this.dom = key;
			this.key = this.dom.getAttribute("data-command");
		} else {
			this.key = key;
			this.dom = document.querySelector("[data-command='"+this.key+"']");
		}
		this.dom.obj = this;
		this.dom.addEventListener("click", function () {
			var cmd;
			cmd = this.obj;
			cmd.execute();
		});
	}
	static init() {

	}
	static execute(key, callback) {
		var xhr;
		if (key.key) {
			key = key.key;
		}
		xhr = new XMLHttpRequest();
		xhr.open("POST", "/php/wdtv.php");
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.obj = this;
		xhr.data = '{"remote":"' + key + '"}';
		callback = callback || function () {
			var res = this.responseText;
			console.log(res);
		};
		xhr.addEventListener("load",callback);
		xhr.send(xhr.data);
		return this;
	}
	execute() {
		this.constructor.execute(this.key);
		return this;
	}
}
Command.init();
