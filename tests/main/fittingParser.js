describe('FittingParser', function() {
  beforeEach(module('mainApp'));

  var FittingParser, _;

  beforeEach(inject(function(_FittingParser_, ___){
    FittingParser = _FittingParser_;
    _ = ___;
  }));

  describe('FittingParser.parseHeader', function() {
    it('FittingParser.parseHeader parses valid header correctly', function() {
      _.each(['[Vexor, cheap solo pvp]',
              '[Vexor,cheap solo pvp]',
              ' [Vexor,cheap solo pvp] '], function(source) {
        var header = FittingParser.parseHeader([source]);
        expect(header.shipType).toEqual('Vexor');
        expect(header.shipName).toEqual('cheap solo pvp');
      });      
    });
    it('FittingParser.parseHeader returns false for invalid header', function() {
      _.each(['[Vexor]',
              '[Vexor,Thorax,cheap solo pvp]'], function(source) {
        var header = FittingParser.parseHeader([source]);
        expect(header).toBe(false);
      });      
    });
  });

  describe('FittingParser.parseRow', function() {
    angular.forEach(['high', 'med', 'low', 'rig'], function(slotType) {
      it('FittingParser.parseRow works correctly with an empty ' + slotType + '-slot', function() {
        _.each([' [empty ' + slotType + ' slot] ', '[ empty ' + slotType + ' slot ]', '[empty  ' + slotType + '    slot]', '[empty ' + slotType + ' slot]'], function(rowContent) {
          var row = FittingParser.parseRow(rowContent);
          expect(row.type).toBe('empty-' + slotType);
          expect(row.item).not.toBeDefined();
          expect(row.amount).not.toBeDefined();
          expect(row.ammo).not.toBeDefined();
        });
      });
    });
    it('FittingParser.parseRow works correctly with a seperator row', function() {
      _.each(['--', ' -- '], function(rowContent) {
        var row = FittingParser.parseRow(rowContent);
        expect(row.type).toBe('seperator');
        expect(row.item).not.toBeDefined();
        expect(row.amount).not.toBeDefined();
        expect(row.ammo).not.toBeDefined();
      });      
    });
    it('FittingParser.parseRow works correctly with an empty row', function() {
      _.each(['', '  '], function(rowContent) {
        var row = FittingParser.parseRow(rowContent);
        expect(row.type).toBe('empty');
        expect(row.item).not.toBeDefined();
        expect(row.amount).not.toBeDefined();
        expect(row.ammo).not.toBeDefined();
      });      
    });
    it('FittingParser.parseRow works correctly with a multible items row', function() {
      _.each([' Nanite Repair Paste x500 ',
              'Nanite Repair Paste x500',
              'Nanite Repair Paste  x500'], function(rowContent) {
        var row = FittingParser.parseRow(rowContent);
        expect(row.item).toEqual('Nanite Repair Paste');
        expect(row.amount).toEqual(500);
        expect(row.ammo).not.toBeDefined();
      });      
    });
    it('FittingParser.parseRow works correctly with an item with ammo', function() {
      _.each(['Anode Ion Particle Cannon I, Caldari Navy Antimatter Charge M',
              'Anode Ion Particle Cannon I,Caldari Navy Antimatter Charge M',
              'Anode Ion Particle Cannon I ,  Caldari Navy Antimatter Charge M',
              ' Anode Ion Particle Cannon I ,  Caldari Navy Antimatter Charge M '], function(rowContent) {
        var row = FittingParser.parseRow(rowContent);
        expect(row.item).toEqual('Anode Ion Particle Cannon I');
        expect(row.ammo).toEqual('Caldari Navy Antimatter Charge M');
        expect(row.amount).not.toBeDefined();
      });
    });
    it('FittingParser.parseRow works correctly with an item without ammo', function() {
      _.each([' Anode Ion Particle Cannon I ',
              'Anode Ion Particle Cannon I'], function(rowContent) {
        var row = FittingParser.parseRow(rowContent);
        expect(row.item).toEqual('Anode Ion Particle Cannon I');
        expect(row.ammo).not.toBeDefined();
        expect(row.amount).not.toBeDefined();
      });
    });
  });
});