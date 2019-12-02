import math

def processCode(data):
    ip = 0
    while True:
        opcode = data[ip]
        if ip >= len(data) or opcode == 99:
            break
        a = data[ip + 1]
        b = data[ip + 2]
        out = data[ip + 3]
        if opcode == 1:
            data[out] = data[a] + data[b]
        elif opcode == 2:
            data[out] = data[a] * data[b]
        ip += 4
    return data

with open ('../../../input/Advent2019/Dec02.txt', 'r') as f:
    records = [record.strip() for record in f.readlines()]

data = records[0].split(',')
data = list(map(int, data))

def partOne():
    data[1] = 12
    data[2] = 2
    return processCode(data.copy())[0]

def partTwo():
    for noun in range(0, 99):
        for verb in range(0, 99):
            data[1] = noun
            data[2] = verb
            if processCode(data.copy())[0] == 19690720:
                return 100 * noun + verb
    return 'error'

#processCode([1,1,2,3,99])
print("Part One Result:")
print(partOne())
print("Part Two Result:")
print(partTwo())