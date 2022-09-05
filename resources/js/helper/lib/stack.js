class Stack {
    #items = []
    push = (element) => this.#items.push(element)
    pop = () => this.#items.pop()
    top = () => this.#items[this.size()-1]
    isempty = () => this.#items.length === 0
    empty = () => (this.#items.length = 0)
    size = () => this.#items.length
}
module.exports = {
    Stack
};