import sourceCode, { SourceCodeParam } from "./sources/SourceCodeSource";
import finDataSource, { finDataSourceParam }  from "./sources/FinDataSource";

var el = document.getElementById("widget");

const param = new SourceCodeParam(0);
param.sourceCode = "usdrub";

const sCodeSource = sourceCode(param);
const fCodeSource = sourceCode(new SourceCodeParam(1));

sCodeSource.byKey(param.sourceCode).then(result => console.log(result));
sCodeSource.load().then(result => console.log(result));
fCodeSource.load().then(result => console.log(result));

finDataSourceParam.sourceCode = "usdrub";

const finSource = finDataSource(() => finDataSourceParam);
finSource.load().then(result => console.log("FinData", result));

class User{
	name : string;
	age : number;
	constructor(_name:string, _age: number){

		this.name = _name;
		this.age = _age;
	}
}
var tom : User = new User("Том", 29);
el.innerHTML = `Имя: ${tom.name} возраст: ${tom.age}`;