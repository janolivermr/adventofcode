import math

def calculateFuel(mass):
    return math.floor(int(mass) / 3) - 2

def calculateFuelRecursive(mass):
    fuel = calculateFuel(mass)
    if fuel <= 0:
        return 0
    return fuel + calculateFuelRecursive(fuel)

with open ('../../../input/Advent2019/Dec01.txt', 'r') as f:
    records = [record for record in f.readlines()]

def partOne():
    fuelRequired = 0
    for record in records:
        fuelRequired += calculateFuel(record)
    return fuelRequired

def partTwo():
    fuelRequired = 0
    for record in records:
        fuelRequired += calculateFuelRecursive(record)
    return fuelRequired


print("Part One Result:")
print(partOne())
print("Part Two Result:")
print(partTwo())